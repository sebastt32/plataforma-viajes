<?php

namespace App\Notifications;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudRechazadaNotification extends Notification
{
    use Queueable;

    public function __construct(public Solicitud $solicitud) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Solicitud rechazada')
            ->greeting('Hola '.$notifiable->name)
            ->line('El viajero rechazó tu solicitud de "'.$this->solicitud->producto->nombre.'".')
            ->action('Ver pedidos', route('pedidos.index'));
    }
}
