<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class ProfileController extends Controller {

    /**
     * Display client dashboard
     */
    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        return view('website.client.dashboard', compact('client'));
    }

    /**
     * Display client orders
     */
    public function orders()
    {
        $client = Auth::guard('client')->user();
        $orders = $client->orders()->latest()->paginate(10);
        return view('website.client.orders', compact('client', 'orders'));
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
        return view('website.client.address-add', compact('client'));
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
            'full_address' => $validated['full_address'] ?? null,
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
        $address = $client->addresses()->findOrFail($addressId);
        return view('website.client.address-edit', compact('client', 'address'));
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
