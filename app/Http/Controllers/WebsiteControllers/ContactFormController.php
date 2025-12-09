<?php

namespace App\Http\Controllers\WebsiteControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Support\Facades\Validator;


class ContactFormController extends Controller {

    public function contactStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => 'required',
            'message' => 'required',
        ], [
            'name.required'    => 'Please enter your name',
            'email.required'   => 'Please enter your email address',
            'email.email'      => 'Please enter a valid email address',
            'phone.required'   => 'Please enter your phone number',
            'message.required' => 'Please enter your message',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $contactForm          = new ContactForm();
        $contactForm->name    = $request->name;
        $contactForm->email   = $request->email;
        $contactForm->phone   = $request->phone;
        $contactForm->message = $request->message;
        $contactForm->save();
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
