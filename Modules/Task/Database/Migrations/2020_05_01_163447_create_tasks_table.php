<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('milestone_id');
            $table->unsignedBigInteger('employee_id');

            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('task_type')->nullable();
            $table->string('task_priority')->default(1);
            $table->integer('assign_by')->nullable();
            
            $table->text('task_description')->nullable();
            
            $table->tinyInteger('task_status')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('estimated_hours')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
