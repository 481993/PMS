<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicProjecttypegablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projecttypegables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('projecttype_id')->unsigned();
            $table->bigInteger('projecttypegable_id')->unsigned();
            $table->string('projecttypegable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projecttypegables');
    }
}
