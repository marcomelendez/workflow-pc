<?php


namespace App\States;


class Pending extends ContentState
{
    public static $name = 'pendiente';

    public function color(): string
    {
        return 'info';
    }
}
