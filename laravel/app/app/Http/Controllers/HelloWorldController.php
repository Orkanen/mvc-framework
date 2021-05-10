<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;

class HelloWorldController extends Controller
{
    /**
     * Display a message.
     *
     * @param  string  $message
     * @return \Illuminate\View\View
     */
    public function hello($message=null)
    {
        $students = Student::all();
        return view('message', [
            'message' => $students,
        ]);
    }
}
