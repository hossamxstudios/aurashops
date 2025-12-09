<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller {

    public function index(){
        $clients = Client::orderBy('id', 'desc')->paginate(16);
        return view('admin.pages.clients.index', compact(['clients']));
    }

    public function profile($id){
        $client = Client::with([
            'skinTone', 
            'skinType', 
            'addresses.city', 
            'addresses.zone', 
            'addresses.district', 
            'concerns', 
            'loyaltyAccount.logs'
        ])->findOrFail($id);

        // Create loyalty account if doesn't exist
        if (!$client->loyaltyAccount) {
            $client->loyaltyAccount()->create([
                'all_points' => 0,
                'points' => 0,
                'used_points' => 0,
            ]);
            $client->load('loyaltyAccount');
        }

        // Load orders with relationships
        $orders = $client->orders()
            ->with(['items.product', 'items.variant', 'orderStatus', 'paymentMethod'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Load reviews with product relationship
        $reviews = $client->reviews()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        // Append product images to reviews
        $reviews->each(function($review) {
            if ($review->product) {
                $review->product->append('image');
            }
        });

        return view('admin.pages.client-profile.index', compact(['client', 'orders', 'reviews']));
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'referred_by_id' => 'nullable|exists:clients,id',
            'skin_tone_id'   => 'nullable|exists:skin_tones,id',
            'skin_type_id'   => 'nullable|exists:skin_types,id',
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'required|email|unique:clients,email',
            'password'       => 'required|string|min:6',
            'gender'         => 'nullable|in:Male,Female',
            'birthdate'      => 'nullable|date',
            'code'           => 'nullable|string|max:50',
            'is_blocked'     => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $client                 = new Client();
        $client->referred_by_id = $request->referred_by_id;
        $client->skin_tone_id   = $request->skin_tone_id;
        $client->skin_type_id   = $request->skin_type_id;
        $client->first_name     = $request->first_name;
        $client->last_name      = $request->last_name;
        $client->phone          = $request->phone;
        $client->email          = $request->email;
        $client->password       = Hash::make($request->password);
        $client->gender         = $request->gender;
        $client->birthdate      = $request->birthdate;
        $client->code           = $request->code;
        $client->is_blocked     = $request->is_blocked ?? 0;
        $client->save();
        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully');
    }

    public function show($id){
        $client = Client::with([
            'skinTone', 
            'skinType', 
            'addresses.city', 
            'addresses.zone', 
            'addresses.district', 
            'concerns', 
            'loyaltyAccount.logs'
        ])->findOrFail($id);

        // Create loyalty account if doesn't exist
        if (!$client->loyaltyAccount) {
            $client->loyaltyAccount()->create([
                'all_points' => 0,
                'points' => 0,
                'used_points' => 0,
            ]);
            $client->load('loyaltyAccount');
        }

        // Load orders with relationships
        $orders = $client->orders()
            ->with(['items.product', 'items.variant', 'orderStatus', 'paymentMethod'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Load reviews with product relationship
        $reviews = $client->reviews()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        // Append product images to reviews
        $reviews->each(function($review) {
            if ($review->product) {
                $review->product->append('image');
            }
        });

        return view('admin.pages.client-profile.index', compact('client', 'orders', 'reviews'));
    }

    public function edit($id){
        $client = Client::findOrFail($id);
        return response()->json($client);
    }

    public function update(Request $request, $id){
        $client = Client::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'referred_by_id' => 'nullable|exists:clients,id',
            'skin_tone_id'   => 'nullable|exists:skin_tones,id',
            'skin_type_id'   => 'nullable|exists:skin_types,id',
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'required|email|unique:clients,email,' . $id,
            'gender'         => 'nullable|in:Male,Female',
            'birthdate'      => 'nullable|date',
            'code'           => 'nullable|string|max:50',
            'is_blocked'     => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $client->referred_by_id = $request->referred_by_id;
        $client->skin_tone_id   = $request->skin_tone_id;
        $client->skin_type_id   = $request->skin_type_id;
        $client->first_name     = $request->first_name;
        $client->last_name      = $request->last_name;
        $client->phone          = $request->phone;
        $client->email          = $request->email;
        $client->gender         = $request->gender;
        $client->birthdate      = $request->birthdate;
        $client->code           = $request->code;
        $client->is_blocked     = $request->is_blocked ?? 0;
        $client->save();

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully');
    }

    public function destroy($id){
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully');
    }

    public function block($id){
        $client = Client::findOrFail($id);
        $client->is_blocked = !$client->is_blocked;
        $client->save();
        $message = $client->is_blocked ? 'Client blocked successfully' : 'Client unblocked successfully';
        return redirect()->route('admin.clients.index')->with('success', $message);
    }

    public function updateSkinProfile(Request $request, $id){
        $client = Client::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'skin_tone_id' => 'nullable|exists:skin_tones,id',
            'skin_type_id' => 'nullable|exists:skin_types,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client->skin_tone_id = $request->skin_tone_id;
        $client->skin_type_id = $request->skin_type_id;
        $client->save();

        return redirect()->back()->with('success', 'Skin profile updated successfully');
    }

    public function updateConcerns(Request $request, $id){
        $client = Client::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'concerns' => 'nullable|array',
            'concerns.*' => 'exists:concerns,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Sync concerns (this will add new ones and remove unselected ones)
        $client->concerns()->sync($request->concerns ?? []);

        return redirect()->back()->with('success', 'Concerns updated successfully');
    }

    public function managePoints(Request $request, $id){
        $client = Client::findOrFail($id);
        $loyaltyAccount = $client->loyaltyAccount;

        if (!$loyaltyAccount) {
            return redirect()->back()->with('error', 'Loyalty account not found');
        }

        $validator = validator()->make($request->all(), [
            'action' => 'required|in:add,subtract',
            'points' => 'required|numeric|min:1',
            'note' => 'nullable|string',
            'expires_at' => 'nullable|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $points = $request->points;
        $pointsBefore = $loyaltyAccount->points;

        if ($request->action == 'add') {
            // Add points
            $loyaltyAccount->points += $points;
            $loyaltyAccount->all_points += $points;
            $type = 'add';
            $message = 'Points added successfully';
        } else {
            // Subtract points
            if ($loyaltyAccount->points < $points) {
                return redirect()->back()->with('error', 'Insufficient points balance');
            }
            $loyaltyAccount->points -= $points;
            $loyaltyAccount->used_points += $points;
            $points = -$points; // Make it negative for logging
            $type = 'subtract';
            $message = 'Points subtracted successfully';
        }

        $pointsAfter = $loyaltyAccount->points;
        $loyaltyAccount->save();

        // Log the transaction
        $loyaltyAccount->logs()->create([
            'type' => $type,
            'points_before' => $pointsBefore,
            'points' => $points,
            'points_after' => $pointsAfter,
            'notes' => $request->note ?? null,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->back()->with('success', $message);
    }

    public function getOrderDetails($orderId){
        $order = \App\Models\Order::with([
            'items.product', 
            'items.variant', 
            'orderStatus', 
            'paymentMethod'
        ])->findOrFail($orderId);

        // Append product images to each order item
        $order->items->each(function($item) {
            if ($item->product) {
                $item->product->append('image');
            }
        });

        return response()->json($order);
    }
}
