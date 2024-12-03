<?php


namespace App\States;


class Rejected extends ContentState
{
    public static $name = 'rechazado';

    public function color(): string
    {
        return 'danger';
    }
}
