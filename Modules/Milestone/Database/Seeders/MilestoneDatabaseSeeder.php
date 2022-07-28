<?php

namespace Modules\Milestone\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Milestone\Entities\Milestone;

class MilestoneDatabaseSeeder extends Seeder
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
         * Milestones Seed
         * ------------------
         */

        DB::table('milestonegables')->truncate();
        echo "Truncate: milestonegables \n";

        DB::table('milestones')->truncate();
        echo "Truncate: milestones \n";

        Milestone::factory()->count(10)->create();
        $milestones = Milestone::all();
        echo " Insert: milestones \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
