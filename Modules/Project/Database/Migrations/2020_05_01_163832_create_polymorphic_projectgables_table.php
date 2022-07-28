<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicProjectgablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectgables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('project_id')->unsigned();
            $table->bigInteger('projectgable_id')->unsigned();
            $table->string('projectgable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projectgables');
    }
}
