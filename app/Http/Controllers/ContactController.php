<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        $to = 'crimechronicles45@gmail.com';
        $subject = 'Jauna ziņa no Crime Chronicles';
        $body = "Vārds: {$validated['name']}\nE-pasts: {$validated['email']}\nZiņa: {$validated['message']}";

        try {
            Mail::raw($body, function ($message) use ($to, $validated, $subject) {
                $message->to($to)
                    ->subject($subject)
                    ->from($validated['email'], $validated['name']);
            });

            return back()->with('success', 'Ziņa nosūtīta!');
        } catch (\Exception $e) {
            return back()->with('error', 'Kļūda sūtot ziņu: ' . $e->getMessage());
        }
    }
}
