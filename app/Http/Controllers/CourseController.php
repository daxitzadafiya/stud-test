<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\PaginationResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses =  Course::all()->where('user_id', Auth::user()->id);
        $courses = $request->input('paginate')
            ? $courses->paginate($request->input('paginate', 25))
            : $courses;

        return $this->sendResponse(
            ['courses' => CourseResource::collection($courses)],
            $request->input('paginate')
                ? ['paginate' => new PaginationResource($courses)]
                : []
        );
    }

    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        Course::create($data);

        return $this->sendResponse([
            'message' => __('Course created successfully.'),
        ]);
    }

    public function show(Course $Course)
    {
        return $this->sendResponse([
            'course' => new CourseResource($Course),
        ]);
    }

    public function update(Course $Course, CourseRequest $request)
    {
        $Course->update($request->validated());

        return $this->sendResponse([
            'message' => __('Course updated successfully.'),
        ]);
    }

    public function destroy(Course $Course)
    {
        $Course->delete();

        return $this->sendResponse([
            'message' => __('Course deleted successfully.'),
        ]);
    }
}
