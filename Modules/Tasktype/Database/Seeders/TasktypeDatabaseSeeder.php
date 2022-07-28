<?php

namespace Modules\Tasktype\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Tasktype\Entities\Tasktype;

class TasktypeDatabaseSeeder extends Seeder
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
         * Tasktypes Seed
         * ------------------
         */

        DB::table('tasktypegables')->truncate();
        echo "Truncate: tasktypegables \n";

        DB::table('tasktypes')->truncate();
        echo "Truncate: tasktypes \n";

        Tasktype::factory()->count(10)->create();
        $tasktypes = Tasktype::all();
        echo " Insert: tasktypes \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
