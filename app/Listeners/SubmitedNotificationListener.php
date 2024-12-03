<?php

namespace App\Listeners;

use App\Notifications\AwaitingApprovalNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use RingleSoft\LaravelProcessApproval\Events\ProcessSubmittedEvent;

class SubmitedNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProcessSubmittedEvent $event): void
    {
        $nextApprovers = $event->approvable->getNextApprovers();
        foreach ($nextApprovers as $nextApprover) {
            $nextApprover->notify(new AwaitingApprovalNotification($event->approvable));
        }
    }
}
