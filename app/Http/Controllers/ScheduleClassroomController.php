<?php

namespace App\Http\Controllers;

use App\ScheduleClassroom;
use Illuminate\Http\Request;

class ScheduleClassroomController extends Controller
{
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
        $schedule = $request->input('schedule', [null]);
        $classroom = $request->input('classroom', [null]);

        if (ScheduleClassroom::where('course_id', $course_id)->where('grade', $grade)->exists()) {
            return response()->json([], 409);
        }

        for ($i = 0; $i < count($schedule); $i++) {
            $post = new ScheduleClassroom;

            $post->course_id = $course_id;
            $post->grade = $grade;
            $post->index = $i;
            $post->schedule = $schedule[$i];
            $post->classroom = ($i < count($classroom) ? $classroom[$i] : null);

            $post->save();
        }

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
        $post = ScheduleClassroom::where('course_id', $course_id)->where('grade', $grade);

        if ($post->exists()) {
            $post->delete();

            return response()->json([], 200);
        }
        return response()->json([], 204);
    }
}
