<?php

namespace App\Console;

use App\Console\Commands\ClearLog;

class Kernel
{
    protected $commands = [
        ClearLog::class,
    ];

}
