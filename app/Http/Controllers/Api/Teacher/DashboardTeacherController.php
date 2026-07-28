<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceCourses;
use App\Models\Course;

class DashboardTeacherController extends Controller
{
    //

    public function countTeacherCourses()
    {
        $teacher = auth()->user();

        $courses = Course::with('area')
            ->withCount(['classes', 'activities'])
            ->where('fk_id_teacher', $teacher->id)
            ->get();

        return response()->json([
            'total_courses'    => $courses->count(),
            'total_lessons'    => $courses->sum('classes_count'),
            'total_activities' => $courses->sum('activities_count'),
            'courses'          => $courses
        ]);
    }

    public function teacherCourses()
    {
        $teacherLogin = auth()->user();

        $courses = Course::with('area')
            ->where('fk_id_teacher', $teacherLogin->id)
            ->get();

        return ResourceCourses::collection($courses);
    }
}
