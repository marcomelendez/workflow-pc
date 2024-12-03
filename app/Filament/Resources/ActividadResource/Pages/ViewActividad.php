<?php

namespace App\Filament\Resources\ActividadResource\Pages;

use App\Filament\Actions\PublishAction;
use App\Filament\Resources\ActividadResource;
use App\Models\Actividad;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewActividad extends ViewRecord
{
    protected static string $resource = ActividadResource::class;

    use  \EightyNine\Approvals\Traits\HasApprovalHeaderActions;


    protected function getHeaderActions(): array
    {
        return [
            PublishAction::make(),
            ...$this->getApprovalHeaderActions()
        ];
    }
       /**
     * Get the completion action.
     *
     * @return Filament\Actions\Action
     * @throws Exception
     */
    protected function getOnCompletionAction(): Action
    {
        return Action::make("Done")
            ->color("success");
            // Do not use the visible method, since it is being used internally to show this action if the approval flow has been completed.
            // Using the hidden method add your condition to prevent the action from being performed more than once
            // ->hidden(fn(Actividad $record)=> $record->shouldBeHidden());
    }
}
