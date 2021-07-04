<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;

class StudentsController extends Controller
{
    public function index()
    {
        $students = Students::all();

        return response()->json(
            [
                'success' => true,
                'message' => 'List of Students',
                'data' => $students
            ],
            200
        );
    }
}
