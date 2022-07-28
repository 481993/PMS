<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicDepartmentgablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departmentgables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('departmentgable_id')->unsigned();
            $table->string('departmentgable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departmentgables');
    }
}
