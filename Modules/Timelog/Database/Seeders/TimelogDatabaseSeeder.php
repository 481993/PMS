<?php

namespace Modules\Timelog\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Timelog\Entities\Timelog;

class TimelogDatabaseSeeder extends Seeder
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
         * Timelogs Seed
         * ------------------
         */

        DB::table('timeloggables')->truncate();
        echo "Truncate: timeloggables \n";

        DB::table('timelogs')->truncate();
        echo "Truncate: timelogs \n";

        Timelog::factory()->count(10)->create();
        $timelogs = Timelog::all();
        echo " Insert: timelogs \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
