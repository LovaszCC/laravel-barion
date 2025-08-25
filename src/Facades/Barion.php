<?php

declare(strict_types=1);

namespace LovaszCC\Barion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LovaszCC\Barion\Barion
 */
final class Barion extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LovaszCC\Barion\Barion::class;
    }
}
