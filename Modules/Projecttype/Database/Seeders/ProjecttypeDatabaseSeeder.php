<?php

namespace Modules\Projecttype\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Projecttype\Entities\Projecttype;

class ProjecttypeDatabaseSeeder extends Seeder
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
         * Projecttypes Seed
         * ------------------
         */

        DB::table('projecttypegables')->truncate();
        echo "Truncate: projecttypegables \n";

        DB::table('projecttypes')->truncate();
        echo "Truncate: projecttypes \n";

        Projecttype::factory()->count(10)->create();
        $projecttypes = Projecttype::all();
        echo " Insert: projecttypes \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
