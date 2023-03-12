<?php

namespace App\Console\Commands;

use App\Traits\StorageTrait;
use Illuminate\Console\Command;

class ClearTemporaryDirectory extends Command
{
    use StorageTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:clear_temporary_directory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear temporary directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->deleteDirectory(TEMP_DIR);
        return Command::SUCCESS;
    }
}
