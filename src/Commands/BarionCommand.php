<?php

declare(strict_types=1);

namespace LovaszCC\Barion\Commands;

use Illuminate\Console\Command;

final class BarionCommand extends Command
{
    public $signature = 'laravel-barion';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
