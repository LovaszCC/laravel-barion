<?php

declare(strict_types=1);

namespace LovaszCC\Barion\Enums;

enum FundingSources: string
{
    case ALL = 'All';
    case BALANCE = 'Balance';
    case BANK_CARD = 'BankCard';
    case GOOGLE_PAY = 'GooglePay';
    case APPLE_PAY = 'ApplePay';
}
