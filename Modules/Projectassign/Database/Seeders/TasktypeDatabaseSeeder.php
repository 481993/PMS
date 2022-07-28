<?php

namespace Modules\Projectassign\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Projectassign\Entities\Projectassign;

class ProjectassignDatabaseSeeder extends Seeder
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
         * Projectassigns Seed
         * ------------------
         */

        DB::table('projectassigngables')->truncate();
        echo "Truncate: projectassigngables \n";

        DB::table('projectassigns')->truncate();
        echo "Truncate: projectassigns \n";

        Projectassign::factory()->count(10)->create();
        $projectassigns = Projectassign::all();
        echo " Insert: projectassigns \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
