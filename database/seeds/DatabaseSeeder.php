<?php

use Illuminate\Database\Seeder;

use App\Information;
use App\ScheduleClassroom;
use App\CoProfessors;
use App\Messages;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $courses = json_decode(file_get_contents('courses.json'));

        foreach ($courses as $course) {
            $basic_information = $course->basic_information;
            $core_ability = $course->core_ability;
            $curriculum_guidelines = $course->curriculum_guidelines;

            for ($i = 0; $i < count($basic_information->class_schedule); $i++) {
                ScheduleClassroom::create([
                    'course_id' => $basic_information->course_id,
                    'grade' => $basic_information->grade,
                    'index' => $i,
                    'schedule' => ($basic_information->class_schedule[$i] == '' ? null : $basic_information->class_schedule[$i]),
                    'classroom' => ($basic_information->classroom[$i] == '' ? null : $basic_information->classroom[$i]),
                ]);
            }

            for ($i = 0; $i < count($basic_information->co_professors); $i++) {
                CoProfessors::create([
                    'course_id' => $basic_information->course_id,
                    'grade' => $basic_information->grade,
                    'index' => $i,
                    'professor' => ($basic_information->co_professors[$i] == '' ? null : $basic_information->co_professors[$i])
                ]);
            }

            Information::create([
                'course_id' => $basic_information->course_id,
                'grade' => $basic_information->grade,
                'professor' => $basic_information->professor,
                'year_semester' => $basic_information->year_semester,
                'faculty_name' => $basic_information->faculty_name,
                'chi_course_name' => $basic_information->course_name->chinese,
                'eng_course_name' => $basic_information->course_name->english,
                'credit' => $basic_information->credit,
                'hour' => $basic_information->hour,
                'max_students' => $basic_information->max_students,
                'min_students' => $basic_information->min_students,
                'category' => $basic_information->category,
                'duration' => $basic_information->duration,
                'internship' => ($basic_information->internship == "是"),
                'main_field' => $basic_information->main_field,
                'sub_field' => $basic_information->sub_field,
                'students' => $basic_information->students,
                'description' => $basic_information->description,
                'core_ability' => ($core_ability == '' ? null : $core_ability),
                'chi_objective' => ($curriculum_guidelines->objective->chinese == '' ? null : $curriculum_guidelines->objective->chinese),
                'eng_objective' => ($curriculum_guidelines->objective->english == '' ? null : $curriculum_guidelines->objective->english),
                'chi_pre_course' => ($curriculum_guidelines->pre_course->chinese == '' ? null : $curriculum_guidelines->pre_course->chinese),
                'eng_pre_course' => ($curriculum_guidelines->pre_course->english == '' ? null : $curriculum_guidelines->pre_course->english),
                'chi_outline' => ($curriculum_guidelines->outline->chinese == '' ? null : $curriculum_guidelines->outline->chinese),
                'eng_outline' => ($curriculum_guidelines->outline->english == '' ? null : $curriculum_guidelines->outline->english),
                'chi_teaching_method' => ($curriculum_guidelines->teaching_method->chinese == '' ? null : $curriculum_guidelines->teaching_method->chinese),
                'eng_teaching_method' => ($curriculum_guidelines->teaching_method->english == '' ? null : $curriculum_guidelines->teaching_method->english),
                'chi_reference' => ($curriculum_guidelines->reference->chinese == '' ? null : $curriculum_guidelines->reference->chinese),
                'eng_reference' => ($curriculum_guidelines->reference->english == '' ? null : $curriculum_guidelines->reference->english),
                'chi_syllabus' => ($curriculum_guidelines->syllabus->chinese == '' ? null : $curriculum_guidelines->syllabus->chinese),
                'eng_syllabus' => ($curriculum_guidelines->syllabus->english == '' ? null : $curriculum_guidelines->syllabus->english),
                'chi_evaluation' => ($curriculum_guidelines->evaluation->chinese == '' ? null : $curriculum_guidelines->evaluation->chinese),
                'eng_evaluation' => ($curriculum_guidelines->evaluation->english == '' ? null : $curriculum_guidelines->evaluation->english),
                'reference_link' => ($curriculum_guidelines->reference_link == '' ? null : $curriculum_guidelines->reference_link)
            ]);
        }
    }
}
