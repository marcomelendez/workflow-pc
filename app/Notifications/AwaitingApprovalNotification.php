<?php

namespace App\Notifications;

use App\Mail\SubmitedMessage;
use App\States\Pending;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use RingleSoft\LaravelProcessApproval\Contracts\ApprovableModel;

class AwaitingApprovalNotification extends Notification
{
    use Queueable;

    protected $modelState;

    /**
     * Create a new notification instance.
     */
    public function __construct($approvableModel)
    {
        $this->modelState = $approvableModel;
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
    public function toMail(object $notifiable): Mailable
    {
        $this->modelState->estado->transitionTo(Pending::class);

        return (new SubmitedMessage($this->modelState))
                    ->subject('Nueva Solicitud para Aprobación')
                    ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
