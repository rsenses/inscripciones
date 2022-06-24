<?php

namespace App\Notifications;

use App\Models\Checkout;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\CheckoutPending as CheckoutPendingMailable;
use Spatie\Multitenancy\Jobs\TenantAware;

class CheckoutPending extends Notification implements ShouldQueue, TenantAware
{
    use Queueable;

    public $checkout;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new CheckoutPendingMailable($this->checkout))
        ->mailer($this->checkout->campaign->mailer)
        ->to($this->checkout->user);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
