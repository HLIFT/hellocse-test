<?php

namespace App\Enums;

enum ProfileStatus: string
{
    case Active = 'active';
    case Waiting = 'waiting';
    case Inactive = 'inactive';
}
