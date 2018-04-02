<?php

namespace App\Listeners;

use App\Mail\VerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendVerificationMail implements ShouldQueue
{


    public function handle(Registered $event): void
    {
        Mail::to($event->user->email)->send(new VerificationMail($event->user));
    }
}
