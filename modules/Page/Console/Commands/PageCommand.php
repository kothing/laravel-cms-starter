<?php

namespace Modules\Page\Console\Commands;

use Illuminate\Console\Command;

class PageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PageCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Page Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
