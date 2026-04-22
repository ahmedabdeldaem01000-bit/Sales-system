<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue

{
    use Queueable;

    /**
     * Create a new notification instance.
     */

public $order;
public $paymentLink;

public function __construct($order, $paymentLink)
{
    $this->order = $order;
    $this->paymentLink = $paymentLink;
}
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

public function toMail($notifiable)
{
    $mail = (new MailMessage)
        ->subject('طلب جديد #' . $this->order->id)
        ->line('تم إنشاء طلبك بنجاح.');

    if (!empty($this->paymentLink)) {
        $mail->action('ادفع الآن عبر PayPal', $this->paymentLink);
    } else {
        $mail->line('تنبيه: لم يتم إنشاء رابط الدفع بشكل صحيح، يرجى التواصل مع الدعم.');
    }

    return $mail;
}

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'link' => $this->paymentLink
        ];
    }


    public function toDatabase($notifiable)
{
    return [
        'order_id' => $this->order->id,
        'payment_link' => $this->paymentLink,
    ];
}


}

