<?php


namespace App\States;


class Published extends ContentState
{
    public static $name = 'publicado';

    public function color(): string
    {
        return 'success';
    }
}
