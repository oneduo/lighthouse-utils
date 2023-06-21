<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils\Commands;

use Illuminate\Console\Command;

class LighthouseUtilsCommand extends Command
{
    public $signature = 'lighthouse-utils';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
