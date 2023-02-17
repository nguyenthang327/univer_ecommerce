<?php

namespace App\Mail;

use App\Models\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class BaseMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $language_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language_id = null)
    {
        $this->language_id = $language_id;
        $language =  Language::find($this->language_id);
        $name = isset($language) ? $language->name : null;
        if($name){
            App::setLocale($name);
        }
    }
}
