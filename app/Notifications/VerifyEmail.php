<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends VerifyEmailBase
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Confirmez votre adresse e-mail')
            ->greeting('Bonjour,')
            ->line('Merci de vous être inscrit sur Pamplescan. Pour compléter votre inscription, veuillez vérifier votre adresse e-mail en cliquant sur le bouton ci-dessous.')
            ->action('Vérifier mon e-mail', $verificationUrl)
            ->line('Si vous n\'avez pas créé de compte, aucune action supplémentaire n\'est requise.')
            ->salutation('Cordialement, L\'équipe Pamplescan');
    }
}
