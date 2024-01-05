<?php

namespace Modules\Page\Database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Tag\Models\Page;

class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Pages Seed
         * ------------------
         */

        // DB::table('pages')->truncate();
        // echo "Truncate: pages \n";

        Page::factory()->count(20)->create();
        $rows = Page::all();
        echo " Insert: pages \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
