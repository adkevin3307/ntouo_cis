<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('information', function (Blueprint $table) {
            $table->foreign('course_id', 'foreign_schedule_classroom')->references('course_id')->on('schedule_classroom');
            $table->foreign('course_id', 'foreign_co_professors')->references('course_id')->on('co_professors');
            // $table->foreign('course_id', 'foreign_message')->references('course_id')->on('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information');
        Schema::dropIfExists('schedule_classroom');
        Schema::dropIfExists('co_professors');
        Schema::dropIfExists('messages');
    }
}
