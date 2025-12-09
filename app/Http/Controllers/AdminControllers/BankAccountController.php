<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::latest()->paginate(20);
        
        return view('admin.pages.bank_accounts.index', compact('bankAccounts'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'swift_bic' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'is_active' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If is_default is set, unset other defaults
        if ($request->is_default) {
            BankAccount::where('is_default', true)->update(['is_default' => false]);
        }

        BankAccount::create([
            'name' => $request->name,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'iban' => $request->iban,
            'swift_bic' => $request->swift_bic,
            'currency' => $request->currency,
            'is_active' => $request->is_active ?? true,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account created successfully');
    }

    public function edit($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        return response()->json($bankAccount);
    }

    public function update(Request $request, $id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'swift_bic' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'is_active' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If is_default is set, unset other defaults
        if ($request->is_default) {
            BankAccount::where('is_default', true)->where('id', '!=', $id)->update(['is_default' => false]);
        }

        $bankAccount->update([
            'name' => $request->name,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'iban' => $request->iban,
            'swift_bic' => $request->swift_bic,
            'currency' => $request->currency,
            'is_active' => $request->is_active ?? false,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account updated successfully');
    }

    public function destroy($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        $bankAccount->delete();

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account deleted successfully');
    }
}
