<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Handle the sending of contact form messages
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        // Prepare the data for the email
        $emailData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'userMessage' => $data['message']
        ];

        // Send the email using the configured SMTP settings
        Mail::send('emails.contact', $emailData, function($message) use ($data) {
            $message->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject('New Contact Message')
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')); // Use the configured SMTP address
        });

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}