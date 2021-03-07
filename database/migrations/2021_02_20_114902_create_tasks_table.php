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
            $table->id();
            $table->integer('type_id');
            $table->integer('client_id');
            $table->string('task_name');
            $table->text('task_description');
            $table->dateTime('task_datetime');
            $table->boolean('task_completed')->default(0);
            $table->boolean('task_succesful')->default(0);
            $table->integer('added_by');
            $table->boolean('complete_xp')->default(0);
            $table->boolean('success_xp')->default(0);
            $table->timestamps();
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
