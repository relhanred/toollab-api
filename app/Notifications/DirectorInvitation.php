<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class DirectorInvitation extends Notification
{
    private $schoolName;
    private $token;
    private $frontendUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $schoolName, string $token)
    {
        $this->schoolName = $schoolName;
        $this->token = $token;
        $this->frontendUrl = config('app.frontend_url', 'http://localhost:3000');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->frontendUrl . '/set-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('Invitation en tant que directeur d\'école')
            ->greeting('Bonjour ' . $notifiable->first_name . ' ' . $notifiable->last_name)
            ->line('Vous avez été invité(e) en tant que directeur/directrice de l\'école ' . $this->schoolName . '.')
            ->line('Pour accéder à votre compte, veuillez définir votre mot de passe en cliquant sur le bouton ci-dessous.')
            ->action('Définir mon mot de passe', $url)
            ->line('Ce lien expirera dans 7 jours.')
            ->line('Si vous n\'avez pas demandé cette invitation, aucune action n\'est requise.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'school_name' => $this->schoolName,
            'invitation_token' => $this->token,
        ];
    }
}
