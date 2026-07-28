<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceCourses;
use App\Http\Resources\TeacherResource;
use App\Models\ActivityCourse;
use App\Models\ClassCourse;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DataTeachers extends Controller
{
    //

    public function counters()
    {
        $teachers   = Teacher::where('role', 'teacher')->where('status', 'approved')->count();
        $students   = User::count();
        $courses    = Course::count();
        $activities = ActivityCourse::count();
        $classes    = ClassCourse::count();


        return response()->json([
            'teachers'   => $teachers,
            'students'   => $students,
            'courses'    => $courses,
            'activities' => $activities,
            'classes'    => $classes,
        ]);
    }
    public function indexTeachers()
    {
        $teachers = Teacher::where('role', 'teacher')->where('status', 'approved')->paginate(10);;

        return response()->json([
            'teachers' => TeacherResource::collection($teachers),
        ]);
    }

    public function classesPerArea()
    {
        $areas = \DB::table('tb_class as c')
            ->join('tb_courses as co', 'c.fk_id_course', '=', 'co.id_course')
            ->join('tb_areas as a', 'co.fk_id_area', '=', 'a.id')
            ->select(
                'a.id',
                'a.name_area',
                'a.slug_area',
                'a.color_area',
                \DB::raw('COUNT(c.id_class) as total_aulas')
            )
            ->groupBy('a.id', 'a.name_area')
            ->orderByDesc('total_aulas')
            ->get();

        return response()->json($areas);
    }

    public function listCourses()
    {
        $courses = Course::with(['area', 'teacher'])
            ->withCount(['classes', 'activities'])
            ->paginate(20);

        return response()->json(ResourceCourses::collection($courses));
    }

    public function blockTeacher(int $id){
        $teacher = Teacher::find($id);
        $teacher->update(['status' => 'rejected']);
        return response()->json([
            'message' => 'Professor bloqueado com sucesso!'
        ]);
    }

    public function unblockTeacher(int $id)
    {
        $teacher = Teacher::find($id);
        $teacher->update(['status' => 'approved']);
        return response()->json([
            'message' => 'Professor bloqueado com sucesso!'
        ]);
    }

}
