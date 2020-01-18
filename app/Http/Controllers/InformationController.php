<?php

namespace App\Http\Controllers;

use App\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    private function mb_chunk_split($s)
    {
        $temp = '';
        for ($i = 0; $i < mb_strlen($s); $i++) {
            $temp .= mb_substr($s, $i, 1);
            if ($i != mb_strlen($s) - 1) $temp .= '%';
        }
        return $temp;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course_id = $request->input('course_id');
        $grade = $request->input('grade');

        if (Information::where('course_id', $course_id)->where('grade', $grade)->exists()) {
            return response()->json([], 409);
        }

        $schedule_classroom_controller = app('App\Http\Controllers\ScheduleClassroomController')->store($request);
        if ($schedule_classroom_controller->status() != 200) return $schedule_classroom_controller;

        $co_professors_controller = app('App\Http\Controllers\CoProfessorsController')->store($request);
        if ($co_professors_controller->status() != 200) return $co_professors_controller;

        $post = new Information;

        $post->course_id = $request->input('course_id');
        $post->grade = $request->input('grade');
        $post->professor = $request->input('professor');
        $post->year_semester = $request->input('year_semester');
        $post->faculty_name = $request->input('faculty_name');
        $post->chi_course_name = $request->input('chi_course_name');
        $post->eng_course_name = $request->input('eng_course_name');
        $post->credit = $request->input('credit');
        $post->hour = $request->input('hour');
        $post->max_students = $request->input('max_students');
        $post->min_students = $request->input('min_students');
        $post->category = $request->input('category');
        $post->duration = $request->input('duration');
        $post->internship = ($request->input('internship') == true);
        $post->main_field = $request->input('main_field');
        $post->sub_field = $request->input('sub_field');
        $post->students = $request->input('students', 0);
        $post->description = ($request->input('description') == null ? '' : $request->input('description'));
        $post->core_ability = $request->input('core_ability', null);
        $post->chi_objective = $request->input('chi_objective', null);
        $post->eng_objective = $request->input('eng_objective', null);
        $post->chi_pre_course = $request->input('chi_pre_course', null);
        $post->eng_pre_course = $request->input('eng_pre_course', null);
        $post->chi_outline = $request->input('chi_outline', null);
        $post->eng_outline = $request->input('eng_outline', null);
        $post->chi_teaching_method = $request->input('chi_teaching_method', null);
        $post->eng_teaching_method = $request->input('eng_teaching_method', null);
        $post->chi_reference = $request->input('chi_reference', null);
        $post->eng_reference = $request->input('eng_reference', null);
        $post->chi_syllabus = $request->input('chi_syllabus', null);
        $post->eng_syllabus = $request->input('eng_syllabus', null);
        $post->chi_evaluation = $request->input('chi_evaluation', null);
        $post->eng_evaluation = $request->input('eng_evaluation', null);
        $post->reference_link = $request->input('reference_link', null);

        $post->save();

        return response()->json($post, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $result = [];
        $url_query = [
            'course_id', 'course_name', 'faculty_name', 'main_field', 'sub_field', 'professor', 
            'grade', 'category', 'description', 'schedule', 'classroom', 'co_professors'
        ];

        if (count($request->except($url_query)) == 0 and count($request->query()) > 0) {
            if ($request->has('course_id')) {
                $posts = Information::where('course_id', $request->course_id)
                    ->where('grade', 'like', "%{$request->query('grade', '')}%")
                    ->where('professor', 'like', "%{$request->query('professor', '')}%")
                    ->get();
            }
            else {
                $posts = Information::where(function ($query) use ($request) {
                        $course_name = $this->mb_chunk_split($request->query('course_name', ''));
                        $query->where('chi_course_name', 'like', "%{$course_name}%")
                            ->orWhere('eng_course_name', 'like', "%{$course_name}%");
                    })
                    ->where(function ($query) use ($request) {
                        $faculty_names = ($request->has('faculty_name') ? explode(',', $request->faculty_name) : []);
                        foreach ($faculty_names as $faculty_name) {
                            $query->orWhere('faculty_name', 'like', "%{$this->mb_chunk_split($faculty_name)}%");
                        }
                    })
                    ->where('professor', 'like', "%{$request->query('professor', '')}%")
                    ->where('grade', 'like', "%{$request->query('grade', '')}%")
                    ->where('main_field', 'like', "%{$request->query('main_field', '')}%")
                    ->where('sub_field', 'like', "%{$request->query('sub_field', '')}%")
                    ->where('category', 'like', "%{$request->query('category', '')}%")
                    ->where('description', 'like', "%{$request->query('description', '')}%")
                    ->get();
            }

            for ($i = 0; $i < count($posts); $i++) {
                $schedule = [];
                $classroom = [];
                $building = [];
                $co_professors = [];

                foreach ($posts[$i]->get_schedule_classroom as $post) {
                    if ($post->schedule != null) array_push($schedule, $post->schedule);
                    if ($post->classroom != null) {
                        array_push($classroom, $post->classroom);
                        array_push($building, preg_split('/[0-9]+/', $post->classroom)[0]);
                    }
                }

                foreach ($posts[$i]->get_co_professors as $post) {
                    if ($post->professor != null) array_push($co_professors, $post->professor);
                }

                $posts[$i]->schedule = $schedule;
                $posts[$i]->classroom = $classroom;
                $posts[$i]->co_professors = $co_professors;
                $posts[$i]->internship = ($posts[$i]->internship == 1);

                unset($posts[$i]->get_schedule_classroom);
                unset($posts[$i]->get_co_professors);
    
                $schedule_query = ($request->has('schedule') ? array_map('intval', explode(',', $request->schedule)) : $schedule);
                $classroom_query = ($request->has('classroom') ? explode(',', $request->classroom) : $building);
                $co_professors_query = ($request->has('co_professors') ? explode(',', $request->co_professors) : $co_professors);

                $flag_1 = (count(array_intersect($schedule_query, $schedule)) > 0 or !$request->has('schedule'));
                $flag_2 = (count(array_intersect($classroom_query, $building)) > 0 or !$request->has('classroom'));
                $flag_3 = (count(array_intersect($co_professors_query, $co_professors)) > 0 or !$request->has('co_professors'));
    
                if ($request->course_id or ($flag_1 and $flag_2 and $flag_3)) array_push($result, $posts[$i]);
            }
        }
        
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $course_id
     * @param  string  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id, $grade)
    {
        $this->destroy($course_id, $grade);

        $this->store($request);

        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $course_id
     * @param  string  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id, $grade)
    {
        $post = Information::where('course_id', $course_id)->where('grade', $grade);
        if ($post->exists()) {
            $post->delete();
    
            app('App\Http\Controllers\ScheduleClassroomController')->destroy($course_id, $grade);
            app('App\Http\Controllers\CoProfessorsController')->destroy($course_id, $grade);
    
            return response()->json([], 200);
        }
        return response()->json([], 204);
    }
}
