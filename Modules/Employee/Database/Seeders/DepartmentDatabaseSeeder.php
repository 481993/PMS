<?php

namespace Modules\Employee\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Employee\Entities\Employee;

class EmployeeDatabaseSeeder extends Seeder
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
         * Employees Seed
         * ------------------
         */

        DB::table('employeegables')->truncate();
        echo "Truncate: employeegables \n";

        DB::table('employees')->truncate();
        echo "Truncate: employees \n";

        Employee::factory()->count(10)->create();
        $employees = Employee::all();
        echo " Insert: employees \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
