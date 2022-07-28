<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicProjectassigngablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectassigngables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('projectassign_id')->unsigned();
            $table->bigInteger('projectassigngable_id')->unsigned();
            $table->string('projectassigngable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projectassigngables');
    }
}
