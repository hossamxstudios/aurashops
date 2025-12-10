<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class ProfileController extends Controller {

    /**
     * Display client dashboard
     */
    public function dashboard(){
        $client = Auth::guard('client')->user();
        return view('website.client.dashboard', compact('client'));
    }

    /**
     * Display client orders
     */
    public function orders(){
        $client = Auth::guard('client')->user();
        $orders = $client->orders()->with(['orderStatus','items.product','items.variant','paymentMethod','address.district.zone.city'])->withCount('items')->latest()->paginate(10);
        return view('website.client.orders', compact('client', 'orders'));
    }

    /**
     * Display single order details
     */
    public function orderShow($orderId){
        $client = Auth::guard('client')->user();

        $order = $client->orders()
            ->with([
                'orderStatus',
                'items.product.media',
                'items.variant',
                'items.options',
                'paymentMethod',
                'shippingRate',
                'address.district.zone.city',
                'payments',
                'client'
            ])
            ->findOrFail($orderId);

        return view('website.client.order-details', compact('client', 'order'));
    }

    /**
     * Display client addresses
     */
    public function addresses()
    {
        $client = Auth::guard('client')->user();
        $addresses = $client->addresses;
        return view('website.client.addresses', compact('client', 'addresses'));
    }

    /**
     * Show form to add new address
     */
    public function addAddress()
    {
        $client = Auth::guard('client')->user();
        $cities = \App\Models\City::orderBy('cityName')->get();
        return view('website.client.address-add', compact('client', 'cities'));
    }

    /**
     * Store new address
     */
    public function storeAddress(Request $request)
    {
        $client = Auth::guard('client')->user();

        $validated = $request->validate([
            'phone' => 'required|string',
            'label' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'district_id' => 'required|exists:districts,id',
            'street' => 'required|string',
            'building' => 'required|string',
            'floor' => 'required|string',
            'apartment' => 'required|string',
            'zip_code' => 'nullable|string',
            'full_address' => 'nullable|string',
            'is_default' => 'nullable|boolean',
        ]);

        // If this is set as default, unset other defaults
        if ($request->has('is_default') && $request->is_default) {
            $client->addresses()->update(['is_default' => false]);
        }

        // Auto-generate full_address if not provided
        if (empty($validated['full_address'])) {
            $district = \App\Models\District::find($validated['district_id']);
            $zone = \App\Models\Zone::find($validated['zone_id']);
            $city = \App\Models\City::find($validated['city_id']);

            $parts = array_filter([
                'Apt ' . $validated['apartment'],
                'Floor ' . $validated['floor'],
                'Building ' . $validated['building'],
                $validated['street'],
                $district ? $district->districtName : null,
                $zone ? $zone->zoneName : null,
                $city ? $city->cityName : null,
            ]);

            $validated['full_address'] = implode(', ', $parts);
        }

        // Create the address
        $address = $client->addresses()->create([
            'phone' => $validated['phone'],
            'label' => $validated['label'],
            'city_id' => $validated['city_id'],
            'zone_id' => $validated['zone_id'],
            'district_id' => $validated['district_id'],
            'street' => $validated['street'],
            'building' => $validated['building'],
            'floor' => $validated['floor'],
            'apartment' => $validated['apartment'],
            'zip_code' => $validated['zip_code'] ?? null,
            'full_address' => $validated['full_address'],
            'is_default' => $request->has('is_default') ? (bool)$request->is_default : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully!',
            'address' => $address
        ]);
    }

    /**
     * Show form to edit address
     */
    public function editAddress(Request $request)
    {
        $client = Auth::guard('client')->user();
        $addressId = $request->query('id');
        $address = $client->addresses()
            ->with(['city', 'zone.city', 'district.zone'])
            ->findOrFail($addressId);

        // Fix data integrity: if zone doesn't belong to city, update city_id
        if ($address->zone && $address->zone->city_id != $address->city_id) {
            Log::warning("Address {$address->id}: city_id mismatch. Zone {$address->zone_id} belongs to city {$address->zone->city_id}, but address has city_id {$address->city_id}");
            $address->city_id = $address->zone->city_id;
            $address->save();
        }

        // Fix data integrity: if district doesn't belong to zone, update zone_id
        if ($address->district && $address->district->zone_id != $address->zone_id) {
            Log::warning("Address {$address->id}: zone_id mismatch. District {$address->district_id} belongs to zone {$address->district->zone_id}, but address has zone_id {$address->zone_id}");
            $address->zone_id = $address->district->zone_id;

            // Also update city_id if needed
            if ($address->district->zone) {
                $address->city_id = $address->district->zone->city_id;
            }
            $address->save();
        }

        $cities = \App\Models\City::orderBy('cityName')->get();
        return view('website.client.address-edit', compact('client', 'address', 'cities'));
    }

    /**
     * Update address
     */
    public function updateAddress(Request $request)
    {
        $client = Auth::guard('client')->user();
        $addressId = $request->input('id');
        $address = $client->addresses()->findOrFail($addressId);

        $validated = $request->validate([
            'phone' => 'required|string',
            'label' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'district_id' => 'required|exists:districts,id',
            'street' => 'required|string',
            'building' => 'required|string',
            'floor' => 'required|string',
            'apartment' => 'required|string',
            'zip_code' => 'nullable|string',
            'full_address' => 'nullable|string',
            'is_default' => 'nullable|boolean',
        ]);

        // If this is set as default, unset other defaults
        if ($request->has('is_default') && $request->is_default) {
            $client->addresses()->where('id', '!=', $addressId)->update(['is_default' => false]);
        }

        // Auto-generate full_address if not provided
        if (empty($validated['full_address'])) {
            $district = \App\Models\District::find($validated['district_id']);
            $zone = \App\Models\Zone::find($validated['zone_id']);
            $city = \App\Models\City::find($validated['city_id']);

            $parts = array_filter([
                'Apt ' . $validated['apartment'],
                'Floor ' . $validated['floor'],
                'Building ' . $validated['building'],
                $validated['street'],
                $district ? $district->districtName : null,
                $zone ? $zone->zoneName : null,
                $city ? $city->cityName : null,
            ]);

            $validated['full_address'] = implode(', ', $parts);
        }

        // Update the address
        $address->update([
            'phone' => $validated['phone'],
            'label' => $validated['label'],
            'city_id' => $validated['city_id'],
            'zone_id' => $validated['zone_id'],
            'district_id' => $validated['district_id'],
            'street' => $validated['street'],
            'building' => $validated['building'],
            'floor' => $validated['floor'],
            'apartment' => $validated['apartment'],
            'zip_code' => $validated['zip_code'] ?? null,
            'full_address' => $validated['full_address'],
            'is_default' => $request->has('is_default') ? (bool)$request->is_default : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully!',
            'address' => $address
        ]);
    }

    /**
     * Delete address
     */
    public function deleteAddress(Request $request)
    {
        $client = Auth::guard('client')->user();
        $addressId = $request->input('id');
        $address = $client->addresses()->findOrFail($addressId);
        $address->delete();

        return redirect()->route('client.addresses')
            ->with('success', 'Address deleted successfully!');
    }

    /**
     * Show profile edit form
     */
    public function edit()
    {
        $client = Auth::guard('client')->user();
        return view('website.client.profile-edit', compact('client'));
    }

    /**
     * Update client profile
     */
    public function update(Request $request)
    {
        $client = Auth::guard('client')->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:clients,email,' . $client->id],
            'phone' => ['required', 'string', 'unique:clients,phone,' . $client->id],
            'gender' => ['required', 'in:male,female'],
            'birthdate' => ['required', 'date', 'before:today'],
            'current_password' => ['nullable', 'current_password:client'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        // Update basic info
        $client->first_name = $validated['first_name'];
        $client->last_name = $validated['last_name'];
        $client->email = $validated['email'];
        $client->phone = $validated['phone'];
        $client->gender = $validated['gender'];
        $client->birthdate = $validated['birthdate'];

        // Update password if provided
        if ($request->filled('password')) {
            $client->password = bcrypt($validated['password']);
        }

        $client->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete client account
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password:client'],
        ]);

        $client = Auth::guard('client')->user();

        Auth::guard('client')->logout();

        $client->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Account deleted successfully!');
    }
}
