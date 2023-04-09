<?php

namespace App\Listeners;

use App\Events\RegisterCustomer;
use App\Jobs\CustomerRegisterEmail;
use App\Mail\CustomerRegister;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CustomerRegisterSendMail
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
    public function handle(RegisterCustomer $event)
    {
        $sendEmail = new CustomerRegister($event->customer, $event->code);
        $sendJob = new CustomerRegisterEmail($event->customer, $sendEmail);

        dispatch($sendJob);
    }
}
