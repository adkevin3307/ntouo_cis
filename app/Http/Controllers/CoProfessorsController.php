<?php

namespace App\Http\Controllers;

use App\CoProfessors;
use Illuminate\Http\Request;

class CoProfessorsController extends Controller
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
        $co_professors = $request->input('co_professors', [null]);

        if (CoProfessors::where('course_id', $course_id)->where('grade', $grade)->exists()) {
            return response()->json([], 409);
        }

        for ($i = 0; $i < count($co_professors); $i++) {
            $post = new CoProfessors;

            $post->course_id = $course_id;
            $post->grade = $grade;
            $post->index = $i;
            $post->professor = $co_professors[$i];
    
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
        $post = CoProfessors::where('course_id', $course_id)->where('grade', $grade);
        
        if ($post->exists()) {
            $post->delete();

            return response()->json([], 200);
        }
        return response()->json([], 204);
    }
}
