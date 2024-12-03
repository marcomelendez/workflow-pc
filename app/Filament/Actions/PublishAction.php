<?php

namespace App\Filament\Actions;

use App\States\Published;
use Closure;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublishAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Publish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('primary')
            ->action('Publish')
            ->icon('heroicon-m-check')
            ->label(__('Publicar'))
            ->visible(
                fn(Model $record) =>
                $record->canBePublishedBy(Auth::user()) && $record->isApprovalCompleted() && !$record->isPublish()
            )
            ->requiresConfirmation()
            ->modalDescription(__('filament-approvals::approvals.actions.approve_confirmation_text'));
    }

    public function action(Closure | string | null $action): static
    {
        if ($action !== 'Publish') {
            throw new \Exception('You\'re unable to override the action for this plugin');
        }

        $this->action = $this->publishModel();

        return $this;
    }


    /**
     * Approve data function.
     *
     */
    private function publishModel(): Closure
    {
        return function (array $data, Model $record): bool {

            $record->estado->transitionTo(Published::class);

            Notification::make()
                ->title('Published successfully')
                ->success()
                ->send();
            return true;
        };
    }

}
