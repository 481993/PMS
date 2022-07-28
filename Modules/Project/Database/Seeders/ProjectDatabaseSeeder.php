<?php

namespace Modules\Project\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Project\Entities\Project;

class ProjectDatabaseSeeder extends Seeder
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
         * Projects Seed
         * ------------------
         */

        DB::table('projectgables')->truncate();
        echo "Truncate: projectgables \n";

        DB::table('projects')->truncate();
        echo "Truncate: projects \n";

        Project::factory()->count(10)->create();
        $projects = Project::all();
        echo " Insert: projects \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
