<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $event;

    public function __construct(Booking $booking, $event)
    {
        $this->booking = $booking;
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject($this->getSubject())
            ->greeting('Olá ' . $notifiable->name);

        switch ($this->event) {
            case 'created':
                $message->line('Sua reserva foi criada com sucesso!')
                    ->line('Número da reserva: ' . $this->booking->id)
                    ->line('Status: Pendente')
                    ->line('Nossa equipe irá analisar sua solicitação e entraremos em contato em breve.');
                break;

            case 'status_changed':
                $message->line('O status da sua reserva foi atualizado!')
                    ->line('Número da reserva: ' . $this->booking->id)
                    ->line('Novo status: ' . ucfirst($this->booking->status));

                if ($this->booking->status === 'confirmed') {
                    $message->line('Detalhes do veículo: ' . $this->booking->vehicle->model . ' - ' . $this->booking->vehicle->plate)
                        ->line('Motorista: ' . $this->booking->driver->name);
                }
                break;
        }

        return $message
            ->line('Data de início: ' . $this->booking->start_date->format('d/m/Y H:i'))
            ->line('Local de partida: ' . $this->booking->pickup_location)
            ->action('Ver detalhes da reserva', url('/bookings/' . $this->booking->id))
            ->line('Obrigado por escolher nossos serviços!');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'event' => $this->event,
            'status' => $this->booking->status,
            'message' => $this->getNotificationMessage(),
        ];
    }

    private function getSubject()
    {
        switch ($this->event) {
            case 'created':
                return 'Nova Reserva Criada - #' . $this->booking->id;
            case 'status_changed':
                return 'Status da Reserva Atualizado - #' . $this->booking->id;
            default:
                return 'Atualização da Reserva - #' . $this->booking->id;
        }
    }

    private function getNotificationMessage()
    {
        switch ($this->event) {
            case 'created':
                return 'Sua reserva #' . $this->booking->id . ' foi criada com sucesso!';
            case 'status_changed':
                return 'O status da sua reserva #' . $this->booking->id . ' foi atualizado para ' . ucfirst($this->booking->status);
            default:
                return 'Sua reserva #' . $this->booking->id . ' foi atualizada';
        }
    }
}
