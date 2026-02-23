<?php

declare(strict_types=1);

namespace App\Enum;

enum MethodName: string
{
    case Standard = 'Standard';
    case Express = 'Express';
    case SameDay = 'SameDay';
}
