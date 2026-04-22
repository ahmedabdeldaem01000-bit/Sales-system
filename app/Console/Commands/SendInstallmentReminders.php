<?php

namespace App\Console\Commands;

use App\Models\InstallmentItem;
use App\Notifications\InstallmentReminderNotification;
use App\Services\PayPalService;
use Illuminate\Console\Command;
 
class SendInstallmentReminders extends Command
{
    protected $signature = 'app:send-installment-reminders';
    protected $description = 'Send installment reminders';

    public function __construct(protected PayPalService $payPalService)
    {
        parent::__construct();
    }

    public function regeneratePaymentLink($item)
    {
        $order = $item->installment->order;

        $link = $this->payPalService->createPayment($order, $item);

        if (!$link) {
            throw new \Exception('Failed to generate PayPal link');
        }

        $item->update([
            'payment_link' => $link,
        ]);

        return $link;
    }

 public function handle()
{
    InstallmentItem::where('status', 'pending')
        ->whereDate('due_date', '<=', now())
        ->whereNull('reminder_sent_at')
        ->with('installment.order.user')
        ->chunk(100, function ($items) {

            foreach ($items as $item) {

                try {

                    if ($item->status !== 'pending') {
                        continue;
                    }

                    if (!$item->payment_link) {
                        $link = $this->regeneratePaymentLink($item);

                        $item->update([
                            'payment_link' => $link,
                            'reminder_sent_at' => now(),
                        ]);
                    }

                    $item->installment->order->user->notify(
                        new InstallmentReminderNotification($item)
                    );

                } catch (\Exception $e) {
                    \Log::error('Reminder failed', [
                        'item_id' => $item->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        });
}

}


