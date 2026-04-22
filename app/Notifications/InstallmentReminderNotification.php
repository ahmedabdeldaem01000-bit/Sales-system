<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstallmentReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $item) {}


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('تذكير بقسط مستحق')
            ->line('المبلغ: ' . $this->item->amount)
            ->line('تاريخ الاستحقاق: ' . $this->item->due_date);

        if ($this->item->payment_link) {
            $mail->action('ادفع الآن', $this->item->payment_link);
            }

        return $mail;
    }

    public function toDatabase($notifiable)
    {
        return [
            'item_id' => $this->item->id,
            'order_id' => $this->item->installment->order_id,
            'amount' => $this->item->amount,
            'payment_link' => $this->item->payment_link,
        ];
    }
}
