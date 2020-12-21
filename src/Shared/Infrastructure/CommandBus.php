<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Application\Command;

interface CommandBus
{
    public function handle(Command $command): void;
}