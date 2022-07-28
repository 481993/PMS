<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelogs', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('milestone_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('task_id');

            $table->string('name');
            $table->string('slug')->nullable();
            $table->date('log_date')->nullable();
            
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->time('break_time')->nullable();
            $table->time('spend_hours')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timelogs');
    }
}
