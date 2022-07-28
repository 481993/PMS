<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicTimelogrightgablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelogrightgables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('timelogright_id')->unsigned();
            $table->bigInteger('timelogrightgable_id')->unsigned();
            $table->string('timelogrightgable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timelogrightgables');
    }
}
