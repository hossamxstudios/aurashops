<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\Client;
use Illuminate\Http\Request;

class NewsletterController extends Controller {
    /**
     * Display a listing of newsletter subscriptions
     */
    public function index(Request $request){
        $query = Newsletter::with('client');
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                  ->orWhereHas('client', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        // Filter by subscription type
        if ($request->filled('type')) {
            if ($request->type === 'guest') {
                $query->whereNull('client_id');
            } elseif ($request->type === 'client') {
                $query->whereNotNull('client_id');
            }
        }
        $newsletters = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pages.newsletters.index', compact('newsletters'));
    }

    /**
     * Store a newly created newsletter subscription
     */
    public function store(Request $request){
        // If client is selected, get their email
        if ($request->filled('client_id') && !$request->filled('email')) {
            $client = Client::find($request->client_id);
            if ($client) {
                $request->merge(['email' => $client->email]);
            }
        }
        
        $validator = validator()->make($request->all(), [
            'email' => 'required|email|unique:newsletters,email',
            'client_id' => 'nullable|exists:clients,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Newsletter::create([
            'email' => $request->email,
            'client_id' => $request->client_id,
        ]);
        return redirect()->route('admin.newsletters.index')->with('success', 'Newsletter subscription added successfully');
    }

    /**
     * Get newsletter for editing (AJAX)
     */
    public function edit($id){
        $newsletter = Newsletter::with('client')->findOrFail($id);
        return response()->json($newsletter);
    }

    /**
     * Update the specified newsletter subscription
     */
    public function update(Request $request, $id){
        $newsletter = Newsletter::findOrFail($id);
        
        // If client is selected, get their email
        if ($request->filled('client_id') && !$request->filled('email')) {
            $client = Client::find($request->client_id);
            if ($client) {
                $request->merge(['email' => $client->email]);
            }
        }
        
        $validator = validator()->make($request->all(), [
            'email' => 'required|email|unique:newsletters,email,' . $id,
            'client_id' => 'nullable|exists:clients,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $newsletter->update([
            'email' => $request->email,
            'client_id' => $request->client_id,
        ]);
        return redirect()->route('admin.newsletters.index')->with('success', 'Newsletter subscription updated successfully');
    }

    /**
     * Remove the specified newsletter subscription
     */
    public function destroy($id){
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();
        return redirect()->route('admin.newsletters.index')->with('success', 'Newsletter subscription deleted successfully');
    }

    /**
     * Export newsletter emails
     */
    public function export(Request $request){
        $query = Newsletter::query();
        // Apply same filters as index
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('type')) {
            if ($request->type === 'guest') {
                $query->whereNull('client_id');
            } elseif ($request->type === 'client') {
                $query->whereNotNull('client_id');
            }
        }
        $emails = $query->pluck('email')->toArray();
        $content = implode("\n", $emails);
        
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="newsletter-emails-' . date('Y-m-d') . '.txt"');
    }
}
