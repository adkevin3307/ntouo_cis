<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoProfessors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co_professors', function (Blueprint $table) {
            $table->string('course_id');
            $table->string('grade');
            $table->integer('index');
            $table->string('professor')->nullable();

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
        Schema::dropIfExists('co_professors');
    }
}
