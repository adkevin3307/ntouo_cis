<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->string('course_id');
            $table->string('grade');
            $table->string('professor');
            $table->integer('year_semester');
            $table->string('faculty_name', 500);
            $table->string('chi_course_name');
            $table->string('eng_course_name');
            $table->integer('credit');
            $table->integer('hour');
            $table->integer('max_students');
            $table->integer('min_students');
            $table->string('category');
            $table->string('duration');
            $table->boolean('internship');
            $table->string('main_field');
            $table->string('sub_field');
            $table->integer('students');
            $table->mediumText('description');
            $table->mediumText('core_ability')->nullable();
            $table->mediumText('chi_objective')->nullable();
            $table->mediumText('eng_objective')->nullable();
            $table->mediumText('chi_pre_course')->nullable();
            $table->mediumText('eng_pre_course')->nullable();
            $table->mediumText('chi_outline')->nullable();
            $table->mediumText('eng_outline')->nullable();
            $table->mediumText('chi_teaching_method')->nullable();
            $table->mediumText('eng_teaching_method')->nullable();
            $table->mediumText('chi_reference')->nullable();
            $table->mediumText('eng_reference')->nullable();
            $table->mediumText('chi_syllabus')->nullable();
            $table->mediumText('eng_syllabus')->nullable();
            $table->mediumText('chi_evaluation')->nullable();
            $table->mediumText('eng_evaluation')->nullable();
            $table->string('reference_link', 500)->nullable();

            $table->primary(['course_id', 'grade']);
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
    }
}
