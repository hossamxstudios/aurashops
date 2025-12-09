<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactForm;

class ContactFormController extends Controller {

    public function index(Request $request) {
        $query = ContactForm::query();
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%');
            });
        }
        $contactForms = $query->paginate(20);
        return view('admin.pages.contact.index', compact('contactForms'));
    }

    public function destroy($id) {
        $contactForm = ContactForm::findOrFail($id);
        $contactForm->delete();
        return redirect()->back()->with('success', 'Contact form deleted successfully!');
    }
    //
}
