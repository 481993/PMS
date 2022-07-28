<?php

namespace Modules\Task\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Task\Entities\Task;

class TaskDatabaseSeeder extends Seeder
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
         * Tasks Seed
         * ------------------
         */

        DB::table('taskgables')->truncate();
        echo "Truncate: taskgables \n";

        DB::table('tasks')->truncate();
        echo "Truncate: tasks \n";

        Task::factory()->count(10)->create();
        $tasks = Task::all();
        echo " Insert: tasks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
