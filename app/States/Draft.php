<?php


namespace App\States;


class Draft extends ContentState
{
    public static $name = 'borrador';

    public function color(): string
    {
        return 'grey';
    }
}
