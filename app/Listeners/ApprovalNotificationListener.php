<?php

namespace App\Listeners;

use App\Notifications\ApprovedNotification;
use App\States\PendingPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use RingleSoft\LaravelProcessApproval\Events\ProcessApprovedEvent;

class ApprovalNotificationListener
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
    public function handle(ProcessApprovedEvent $event): void
    {
        $nextApprovers = $event->approval->approvable()->get();
        foreach ($nextApprovers as $nextApprover) {
            $nextApprover->estado->transitionTo(PendingPublished::class);
        }
    }
}
