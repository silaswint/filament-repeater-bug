<?php

namespace App\Console;

use Illuminate\Console\Command;

class AbstractCommand extends Command
{
    public function getSignature(): string
    {
        return $this->signature;
    }
}
