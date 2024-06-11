<x-mail::message>
    {{-- Logo --}}
    <img src="{{ asset('public/picture/logo.png') }}" alt="Your Logo" style="max-width: 150px;">

    {{-- Greeting --}}
    Bonjour,

    {{-- Intro Lines --}}
    Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.

    {{-- Action Button --}}
    [Réinitialiser le mot de passe]({{ $actionUrl }})

    {{-- Outro Lines --}}
    Ce lien de réinitialisation de mot de passe expirera dans 60 minutes.

    {{-- Salutation --}}
    Cordialement,
    Votre équipe Pamplescan.fr

    {{-- Subcopy --}}
    Si vous rencontrez des difficultés à cliquer sur le bouton "Réinitialiser le mot de passe", copiez et collez le lien suivant dans votre navigateur Web : [{{ $displayableActionUrl }}]({{ $actionUrl }})
</x-mail::message>

