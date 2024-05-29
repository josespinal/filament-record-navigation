<?php

namespace JoseEspinal\FilamentRecordNavigation\Commands;

use Illuminate\Console\Command;

class FilamentRecordNavigationCommand extends Command
{
    public $signature = 'filament-record-navigation';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
