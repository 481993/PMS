<?php

namespace Modules\Timelogright\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Timelogright\Entities\Timelogright;

class TimelogrightDatabaseSeeder extends Seeder
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
         * Timelogrights Seed
         * ------------------
         */

        DB::table('timelogrightgables')->truncate();
        echo "Truncate: timelogrightgables \n";

        DB::table('timelogrights')->truncate();
        echo "Truncate: timelogrights \n";

        Timelogright::factory()->count(10)->create();
        $timelogrights = Timelogright::all();
        echo " Insert: timelogrights \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
