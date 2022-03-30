<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $students =  Student::all()->where('user_id', Auth::user()->id);
        $students = $request->input('paginate')
            ? $students->paginate($request->input('paginate', 25))
            : $students;

        return $this->sendResponse(
            ['students' => StudentResource::collection($students)],
            $request->input('paginate')
                ? ['paginate' => new PaginationResource($students)]
                : []
        );
    }

    public function store(StudentRequest $request)
    {
        $data = $request->validated();
        Student::create($data);

        return $this->sendResponse([
            'message' => __('Student created successfully.'),
        ]);
    }

    public function show(Student $student)
    {
        return $this->sendResponse([
            'course' => new StudentResource($student),
        ]);
    }

    public function update(Student $student, StudentRequest $request)
    {
        $student->update($request->validated());

        return $this->sendResponse([
            'message' => __('student updated successfully.'),
        ]);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return $this->sendResponse([
            'message' => __('student deleted successfully.'),
        ]);
    }
}
