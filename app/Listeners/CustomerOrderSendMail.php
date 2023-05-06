<?php

namespace App\Listeners;

use App\Jobs\CustomerOrderEmail;
use App\Mail\CustomerOrder as MailCustomerOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CustomerOrderSendMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $sendEmail = new MailCustomerOrder($event->customer, $event->order);
        $sendJob = new CustomerOrderEmail($event->customer, $sendEmail);

        dispatch($sendJob);
    }
}
