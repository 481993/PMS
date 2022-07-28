<?php

namespace Modules\Resource\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Resource\Entities\Resource;

class ResourceDatabaseSeeder extends Seeder
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
         * Resources Seed
         * ------------------
         */

        DB::table('resourcegables')->truncate();
        echo "Truncate: resourcegables \n";

        DB::table('resources')->truncate();
        echo "Truncate: resources \n";

        Resource::factory()->count(10)->create();
        $resources = Resource::all();
        echo " Insert: resources \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
