<?php

namespace App\Listeners;

use App\Events\RegisterUser;
use App\Jobs\RegisterEmail;
use App\Mail\Register;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterSendMail
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
    public function handle(RegisterUser $event)
    {
        $sendEmail = new Register($event->user, $event->password);
        $sendJob = new RegisterEmail($event->user, $sendEmail);

        dispatch($sendJob);
    }
}
