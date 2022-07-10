<?php

namespace App\Enums;

enum Status : string
{
    case ToDo = 'To Do';
    case Doing = 'Doing';
    case Done = 'Done';

    public function toString() : string
    {
        return match($this)
        {
            self::ToDo => 'To Do',
            self::Doing => 'Doing',
            self::Done => 'Done',
        };
    }
}