<?php

declare(strict_types=1);

namespace LovaszCC\Barion\Enums;

enum PaymentType: string
{
    case IMMEDIATE = 'Immediate';
    case RESERVATION = 'Reservation';
}
