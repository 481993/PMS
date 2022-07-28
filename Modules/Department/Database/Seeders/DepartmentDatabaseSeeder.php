<?php

namespace Modules\Department\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Department\Entities\Department;

class DepartmentDatabaseSeeder extends Seeder
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
         * Departments Seed
         * ------------------
         */

        DB::table('departmentgables')->truncate();
        echo "Truncate: departmentgables \n";

        DB::table('departments')->truncate();
        echo "Truncate: departments \n";

        Department::factory()->count(10)->create();
        $departments = Department::all();
        echo " Insert: departments \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
