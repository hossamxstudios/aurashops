<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supply;
use App\Models\SupplyItem;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller {

    public function index(){
        $supplies = Supply::with(['supplier', 'warehouse'])
            ->latest()
            ->paginate(20);

        $suppliers = Supplier::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();

        return view('admin.pages.supplies.index', compact('supplies', 'suppliers', 'warehouses'));
    }

    public function create(){
        $suppliers = Supplier::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::where('type', '!=', 'bundle')->get();
        return view('admin.pages.supplies.create', compact('suppliers', 'warehouses', 'products'));
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'status' => 'required|in:pending,completed,cancelled',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_amount' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:variants,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['qty'] * $item['unit_price'];
            }

            $taxAmount = ($subtotal * ($request->tax_rate ?? 0)) / 100;

            // Calculate discount
            $discountAmount = 0;
            if ($request->discount_type === 'percentage') {
                $discountAmount = ($subtotal * ($request->discount_amount ?? 0)) / 100;
            } else {
                $discountAmount = $request->discount_amount ?? 0;
            }

            $total = $subtotal + $taxAmount - $discountAmount;

            // Create supply
            $supply = Supply::create([
                'supplier_id' => $request->supplier_id,
                'warehouse_id' => $request->warehouse_id,
                'status' => $request->status,
                'tax_rate' => $request->tax_rate ?? 0,
                'discount_type' => $request->discount_type,
                'discount_amount' => $request->discount_amount ?? 0,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total' => $total,
                'is_delivered' => false,
            ]);

            // Add items
            foreach ($request->items as $item) {
                SupplyItem::create([
                    'supply_id' => $supply->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['qty'] * $item['unit_price'],
                ]);
            }

            // Update supplier's last_supply_at
            $supplier = Supplier::find($request->supplier_id);
            $supplier->update(['last_supply_at' => now()]);

            // If completed, update stock
            if ($request->status === 'completed') {
                $supply->update(['is_delivered' => true]);
                $this->updateStockForSupply($supply);
            }

            DB::commit();
            return redirect()->route('admin.supplies.show', $supply->id)->with('success', 'Supply created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create supply: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id){
        $supply = Supply::with(['supplier', 'warehouse', 'supplyItems.product', 'supplyItems.variant'])
            ->findOrFail($id);

        // Exclude bundle products
        $products = Product::where('type', '!=', 'bundle')->get();

        return view('admin.pages.supplies.show', compact('supply', 'products'));
    }

    public function edit($id){
        $supply = Supply::findOrFail($id);
        return response()->json($supply);
    }

    public function update(Request $request, $id){
        $supply = Supply::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'status' => 'required|in:pending,completed,cancelled',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supply->update([
            'supplier_id' => $request->supplier_id,
            'warehouse_id' => $request->warehouse_id,
            'status' => $request->status,
            'tax_rate' => $request->tax_rate ?? 0,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount ?? 0,
        ]);

        // Recalculate totals
        $this->recalculateSupplyTotals($supply);

        return redirect()->route('admin.supplies.index')->with('success', 'Supply updated successfully');
    }

    public function destroy($id){
        $supply = Supply::findOrFail($id);
        $supply->delete();

        return redirect()->route('admin.supplies.index')->with('success', 'Supply deleted successfully');
    }

    /**
     * Add item to supply
     */
    public function addItem(Request $request, $supplyId){
        $supply = Supply::findOrFail($supplyId);

        $validator = validator()->make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:variants,id',
            'qty' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $qty = $request->qty;
        $unitPrice = $request->unit_price;
        $total = $qty * $unitPrice;

        DB::beginTransaction();
        try {
            // Create supply item
            SupplyItem::create([
                'supply_id' => $supplyId,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id ?? null,
                'qty' => $qty,
                'unit_price' => $unitPrice,
                'total' => $total,
            ]);

            // Recalculate supply totals
            $this->recalculateSupplyTotals($supply);

            // If supply is completed, update stock automatically
            if ($supply->status === 'completed' && !$supply->is_delivered) {
                $this->updateStockForSupply($supply);
            }

            DB::commit();
            return redirect()->route('admin.supplies.show', $supplyId)->with('success', 'Item added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add item: ' . $e->getMessage());
        }
    }

    /**
     * Delete supply item
     */
    public function deleteItem($supplyId, $itemId){
        $item = SupplyItem::where('supply_id', $supplyId)->findOrFail($itemId);
        $supply = Supply::findOrFail($supplyId);

        $item->delete();

        // Recalculate supply totals
        $this->recalculateSupplyTotals($supply);

        return redirect()->route('admin.supplies.show', $supplyId)->with('success', 'Item deleted successfully');
    }

    /**
     * Complete supply and update stock
     */
    public function completeSupply($id)
    {
        $supply = Supply::findOrFail($id);

        if ($supply->is_delivered) {
            return redirect()->back()->with('error', 'Supply already delivered');
        }

        DB::beginTransaction();
        try {
            // Update supply status
            $supply->update([
                'status' => 'completed',
                'is_delivered' => true,
            ]);

            // Update stock for all items
            $this->updateStockForSupply($supply);

            DB::commit();
            return redirect()->route('admin.supplies.show', $id)->with('success', 'Supply completed and stock updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to complete supply: ' . $e->getMessage());
        }
    }

    /**
     * Get variants by product
     */
    public function getVariantsByProduct($productId)
    {
        $variants = Variant::where('product_id', $productId)->get();
        return response()->json($variants);
    }

    /**
     * Recalculate supply totals
     */
    private function recalculateSupplyTotals($supply)
    {
        $subtotal = $supply->supplyItems()->sum('total');
        $taxAmount = ($subtotal * $supply->tax_rate) / 100;

        // Calculate discount based on type
        $discountAmount = 0;
        if ($supply->discount_type === 'percentage') {
            $discountAmount = ($subtotal * $supply->discount_amount) / 100;
        } else {
            $discountAmount = $supply->discount_amount;
        }

        $total = $subtotal + $taxAmount - $discountAmount;

        $supply->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ]);
    }

    /**
     * Update stock for supply items
     */
    private function updateStockForSupply($supply)
    {
        foreach ($supply->supplyItems as $item) {
            // Find or create stock record
            $stock = Stock::firstOrCreate(
                [
                    'warehouse_id' => $supply->warehouse_id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                ],
                [
                    'qty' => 0,
                    'reorder_qty' => 10,
                    'is_active' => true,
                ]
            );

            // Add quantity to stock
            $stock->qty += $item->qty;
            $stock->save();

            // Update product base_price (average of old and new prices)
            $product = Product::find($item->product_id);
            if ($product) {
                if ($product->base_price > 0) {
                    // Calculate average of old and new price
                    $product->base_price = ($product->base_price + $item->unit_price) / 2;
                } else {
                    // First time, set directly
                    $product->base_price = $item->unit_price;
                }
                $product->save();
            }

            // Create stock log
            StockLog::create([
                'stock_id' => $stock->id,
                'type' => 'purchase',
                'qty' => $item->qty,
                'notes' => 'Supply #' . $supply->id . ' from ' . $supply->supplier->name,
                'reference_id' => $supply->id,
                'reference_type' => 'supply',
                'cost_per_unit' => $item->unit_price,
                'total_cost' => $item->total,
            ]);
        }
    }
}
