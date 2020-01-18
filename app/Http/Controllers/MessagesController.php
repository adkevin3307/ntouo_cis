<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Messages;

        $post->course_id = $request->input('course_id');
        $post->grade = $request->input('grade');
        $post->content = $request->input('content');

        $post->save();

        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $course_id
     * @return \Illuminate\Http\Response
     */
    public function show($course_id, $grade)
    {
        $post = Messages::where('course_id', $course_id)->where('grade', $grade)->get();

        return response()->json($post->toArray(), 200);
    }
}
