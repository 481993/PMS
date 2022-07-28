<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicEmployeerolegablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeerolegables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('employeerole_id')->unsigned();
            $table->bigInteger('employeerolegable_id')->unsigned();
            $table->string('employeerolegable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeerolegables');
    }
}
