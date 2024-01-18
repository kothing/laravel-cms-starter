<?php

declare(strict_types=1);

namespace Star\LogViewer\Commands;

use Star\LogViewer\Tables\StatsTable;

/**
 * Class     StatsCommand
 */
class StatsCommand extends Command
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name        = 'log-viewer:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display stats of all logs.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature   = 'log-viewer:stats';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Load Data
        $stats   = $this->logViewer->statsTable('en');

        $rows    = $stats->rows();
        $rows[]  = $this->tableSeparator();
        $rows[]  = $this->prepareFooter($stats);

        // Display Data
        $this->displayLogViewer();
        $this->table($stats->header(), $rows);

        return static::SUCCESS;
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Prepare footer.
     *
     * @param  \Star\LogViewer\Tables\StatsTable  $stats
     *
     * @return array
     */
    private function prepareFooter(StatsTable $stats)
    {
        $files = [
            'count' => count($stats->rows()).' log file(s)'
        ];

        return $files + $stats->footer();
    }
}
