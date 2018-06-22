<?php

namespace Illuminate\Auth\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Recuperar contraseña')
            ->greeting('Hola')
            ->line('Recibió este correo electrónico porque hemos recepcionado una solicitud de cambio de contraseña para su cuenta.')
            ->action('Cambiar contraseña', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Si no solicitó un cambio de contraseña, no se requieren más acciones.')
            ->salutation('Saludos, Baquedano Rentas');;
    }
}
