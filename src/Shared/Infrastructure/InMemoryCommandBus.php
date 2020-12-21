<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Application\Command;

class InMemoryCommandBus implements CommandBus
{
    private array $handlers;

    public function map(string $command, callable $handler): void
    {
        $this->handlers[$command] = $handler;
    }

    public function handle(Command $command): void
    {
        $fqcn = \get_class($command);

        if (isset($this->handlers[$fqcn]) === false) {
            throw new HandlerNotFoundException('Unable to find handler for given command.');
        }

        call_user_func($this->handlers[$fqcn], $command);
    }
}