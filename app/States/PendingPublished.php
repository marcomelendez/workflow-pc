<?php

namespace App\States;

class PendingPublished extends ContentState
{
    public static $name = 'por publicar';

    public function color(): string
    {
        return 'warning';
    }
}
