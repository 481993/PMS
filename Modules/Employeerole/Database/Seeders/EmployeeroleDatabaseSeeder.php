<?php

namespace Modules\Employeerole\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Employeerole\Entities\Employeerole;

class EmployeeroleDatabaseSeeder extends Seeder
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
         * Employeeroles Seed
         * ------------------
         */

        DB::table('employeerolegables')->truncate();
        echo "Truncate: employeerolegables \n";

        DB::table('employeeroles')->truncate();
        echo "Truncate: employeeroles \n";

        Employeerole::factory()->count(10)->create();
        $employeeroles = Employeerole::all();
        echo " Insert: employeeroles \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
