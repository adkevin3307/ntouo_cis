<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleClassroom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_classroom', function (Blueprint $table) {
            $table->string('course_id');
            $table->string('grade');
            $table->integer('index');
            $table->integer('schedule')->nullable();
            $table->string('classroom')->nullable();

            $table->primary(['course_id', 'grade', 'index']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_classroom');
    }
}
