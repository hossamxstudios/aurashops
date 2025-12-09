<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Variant;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['warehouse', 'product', 'variant'])
            ->latest()
            ->paginate(20);
        
        $warehouses = Warehouse::where('is_active', true)->get();
        // Exclude bundle products from stock management
        $products = Product::where('type', '!=', 'bundle')->get();
        $variants = Variant::all();
        
        return view('admin.pages.stocks.index', compact('stocks', 'warehouses', 'products', 'variants'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:variants,id',
            'qty' => 'required|integer|min:0',
            'reorder_qty' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if stock record already exists for this combination
        $existingStock = Stock::where('warehouse_id', $request->warehouse_id)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($existingStock) {
            return redirect()->back()
                ->withErrors(['error' => 'Stock record already exists for this warehouse, product, and variant combination.'])
                ->withInput();
        }

        Stock::create([
            'warehouse_id' => $request->warehouse_id,
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id,
            'qty' => $request->qty,
            'reorder_qty' => $request->reorder_qty,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.stocks.index')->with('success', 'Stock created successfully');
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return response()->json($stock);
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:variants,id',
            'qty' => 'required|integer|min:0',
            'reorder_qty' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if another stock record exists for this combination
        $existingStock = Stock::where('warehouse_id', $request->warehouse_id)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existingStock) {
            return redirect()->back()
                ->withErrors(['error' => 'Stock record already exists for this warehouse, product, and variant combination.'])
                ->withInput();
        }

        $stock->update([
            'warehouse_id' => $request->warehouse_id,
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id,
            'qty' => $request->qty,
            'reorder_qty' => $request->reorder_qty,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->route('admin.stocks.index')->with('success', 'Stock updated successfully');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('admin.stocks.index')->with('success', 'Stock deleted successfully');
    }

    /**
     * Show stock details with logs
     */
    public function show($id)
    {
        $stock = Stock::with(['warehouse', 'product', 'variant', 'stockLogs'])
            ->findOrFail($id);
        
        return view('admin.pages.stocks.show', compact('stock'));
    }

    /**
     * Store a stock log (movement)
     */
    public function storeLog(Request $request, $stockId)
    {
        $stock = Stock::findOrFail($stockId);
        
        $validator = validator()->make($request->all(), [
            'type' => 'required|string|in:add,remove,purchase,sale,return,adjustment,damage,loss',
            'qty' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
            'reference_id' => 'nullable|string|max:255',
            'reference_type' => 'nullable|string|max:255',
            'cost_per_unit' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $qty = $request->qty;
        $costPerUnit = $request->cost_per_unit ?? 0;
        $totalCost = $qty * $costPerUnit;

        // Create the log
        StockLog::create([
            'stock_id' => $stockId,
            'type' => $request->type,
            'qty' => $qty,
            'notes' => $request->notes,
            'reference_id' => $request->reference_id,
            'reference_type' => $request->reference_type,
            'cost_per_unit' => $costPerUnit,
            'total_cost' => $totalCost,
        ]);

        // Update stock quantity based on type
        if (in_array($request->type, ['add', 'purchase', 'return'])) {
            $stock->qty += $qty;
        } elseif (in_array($request->type, ['remove', 'sale', 'damage', 'loss'])) {
            $stock->qty -= $qty;
            // Prevent negative stock
            if ($stock->qty < 0) {
                $stock->qty = 0;
            }
        }
        // For 'adjustment', we don't automatically modify qty, user should manually update stock

        $stock->save();

        return redirect()->route('admin.stocks.show', $stockId)->with('success', 'Stock log added successfully');
    }

    /**
     * Delete a stock log
     */
    public function destroyLog($stockId, $logId)
    {
        $log = StockLog::where('stock_id', $stockId)->findOrFail($logId);
        $log->delete();

        return redirect()->route('admin.stocks.show', $stockId)->with('success', 'Stock log deleted successfully');
    }

    /**
     * Get variants by product
     */
    public function getVariantsByProduct($productId)
    {
        $variants = Variant::where('product_id', $productId)->get();
        return response()->json($variants);
    }
}
