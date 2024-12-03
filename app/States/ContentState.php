<?php

namespace App\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class ContentState extends State
{
    abstract public function color(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class)
            ->allowTransition(Draft::class, Pending::class)
            ->allowTransition(Pending::class, PendingPublished::class)
            ->allowTransition(Pending::class, Draft::class)
            ->allowTransition(PendingPublished::class, Published::class)
            ->registerState(Draft::class)
            ->registerState([Pending::class, PendingPublished::class, Published::class]);
    }
}
