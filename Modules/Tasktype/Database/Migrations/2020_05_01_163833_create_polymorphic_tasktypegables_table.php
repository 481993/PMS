<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicTasktypegablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasktypegables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('tasktype_id')->unsigned();
            $table->bigInteger('tasktypegable_id')->unsigned();
            $table->string('tasktypegable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasktypegables');
    }
}
