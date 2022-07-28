<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicResourcegablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resourcegables', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('resource_id')->unsigned();
            $table->bigInteger('resourcegable_id')->unsigned();
            $table->string('resourcegable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resourcegables');
    }
}
