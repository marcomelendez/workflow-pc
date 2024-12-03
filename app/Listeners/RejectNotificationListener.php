<?php

namespace App\Listeners;

use App\States\Draft;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use RingleSoft\LaravelProcessApproval\DataObjects\ApprovalStatusStepData;
use RingleSoft\LaravelProcessApproval\Enums\ApprovalActionEnum;
use RingleSoft\LaravelProcessApproval\Events\ProcessRejectedEvent;

class RejectNotificationListener
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
    public function handle(ProcessRejectedEvent $event): void
    {
        $nextApprover = $event->approval->approvable;

        $steps = ApprovalStatusStepData::collectionFromProcessApprovalStatus($nextApprover->approvalStatus);
        $current = $steps->map(static function (ApprovalStatusStepData $step) {
            return $step->reset();
        });

        $action = ApprovalActionEnum::CREATED;
        $nextApprover->approvalStatus()->update([
            'steps' => ApprovalStatusStepData::collectionToArray($current),
            'status' => $action
        ]);

        $nextApprover->estado->transitionTo(Draft::class);

    }
}
