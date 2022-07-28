<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicTimeloggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeloggables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('timelog_id')->unsigned();
            $table->bigInteger('timeloggable_id')->unsigned();
            $table->string('timeloggable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeloggables');
    }
}
