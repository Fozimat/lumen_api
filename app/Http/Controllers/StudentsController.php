<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'major' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Please fill all fields',
                    'data' => $validator->errors()
                ],
                401
            );
        } else {
            $students = Students::create([
                'name' => $request->input('name'),
                'major' => $request->input('major')
            ]);

            if ($students) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Students saved successfully',
                        'data' => $students
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Students not saved',
                    ],
                    400
                );
            }
        }
    }
}
