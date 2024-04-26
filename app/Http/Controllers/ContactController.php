<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
public function send(Request $request)
{
    $data = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email',
        'message' => 'required'
    ]);

    // Préparez les données pour l'email
    $emailData = [
        'name' => $data['name'],
        'email' => $data['email'],
        'userMessage' => $data['message']
    ];

    Mail::send('emails.contact', $emailData, function($message) use ($data) {
        $message->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject('Nouveau Message de Contact')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')); // Utiliser l'adresse configurée pour SMTP
    });

    return redirect()->route('contact')->with('success', 'Votre message a été envoyé avec succès!');
}


}
