<?php

namespace App\Notifications;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudConfirmadaNotification extends Notification
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
            ->subject('Solicitud confirmada')
            ->greeting('Hola '.$notifiable->name)
            ->line('El viajero confirmó tu solicitud de "'.$this->solicitud->producto->nombre.'".')
            ->line('Ya puedes pagar el producto más el fee de transporte.')
            ->action('Pagar ahora', route('pedidos.show', $this->solicitud));
    }
}
