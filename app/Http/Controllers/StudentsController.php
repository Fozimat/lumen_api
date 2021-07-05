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

    public function show($id)
    {
        $student = Students::find($id);

        if ($student) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Detail of Student',
                    'data' => $student
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Student not found'
                ],
                404
            );
        }
    }

    public function update(Request $request, $id)
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
            $student = Students::where('id', $id)->update([
                'name' => $request->input('name'),
                'major' => $request->input('major')
            ]);

            if ($student) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Student updated successfully',
                        'data' => $student
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Student not updated'
                    ],
                    400
                );
            }
        }
    }

    public function destroy($id)
    {
        $student = Students::find($id);

        if ($student) {
            $student->delete();
            $data = [
                'success' => true,
                'message' => 'Student deleted successfully'
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'success' => false,
                'message' => 'Student not found'
            ];
            return response()->json($data, 404);
        }
    }

    public function search(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $students = Students::where('name', 'LIKE', '%' . $search . '%')->get();
            $count = count($students);
            if ($count > 0) {
                $data = [
                    'success' => true,
                    'message' => $count . ' Student found',
                    'data' => $students
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    'success' => false,
                    'message' => 'Student data not found'
                ];
                return response()->json($data, 404);
            }
        }
    }
}
