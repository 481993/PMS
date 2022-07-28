<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicTaskgablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskgables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('taskgable_id')->unsigned();
            $table->string('taskgable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taskgables');
    }
}
