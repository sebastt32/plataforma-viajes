<?php

namespace App\Notifications;

use App\Models\Pago;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PagoProcesadoNotification extends Notification
{
    use Queueable;

    public function __construct(public Pago $pago) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pago procesado')
            ->greeting('Hola '.$notifiable->name)
            ->line('El sistema de pagos procesó tu compra.')
            ->line('Referencia: '.$this->pago->referencia)
            ->line('Total: $'.number_format((float) $this->pago->total, 2))
            ->action('Ver pedido', route('pedidos.show', $this->pago->solicitud_id));
    }
}
