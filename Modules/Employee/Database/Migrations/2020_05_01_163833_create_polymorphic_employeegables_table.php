<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicEmployeegablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeegables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('employeegable_id')->unsigned();
            $table->string('employeegable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeegables');
    }
}
