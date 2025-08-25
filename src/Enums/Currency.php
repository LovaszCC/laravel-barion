<?php

declare(strict_types=1);

namespace LovaszCC\Barion\Enums;

enum Currency: string
{
    case HUF = 'HUF';
    case EUR = 'EUR';
    case USD = 'USD';
}
