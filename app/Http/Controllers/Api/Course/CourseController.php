<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\ContentCourseResource;
use App\Http\Resources\ResourceCourses;
use App\Http\Resources\ResourceCoursesShow;
use App\Models\ActivityCourse;
use App\Models\Area;
use App\Models\ClassCourse;
use App\Models\Course;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $query = Course::with('area')->where('active_course', true);

        if ($request->filled('search')) {
            $query->where('title_course', 'ilike', "%{$request->search}%");
        }

        if ($request->filled('area_slug')) {
            $query->whereHas('area', function ($q) use ($request) {
                $q->where('slug_area', $request->area_slug);
            });
        }

        $courses = $query->get();

        return ResourceCourses::collection($courses);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $data = $request->validated();

        $area = Area::where('slug_area', $data['slug_area'])->firstOrFail();

        $path = $request->file('url_image_course')->store('course_image', 'public');

        $course = Course::create([
            'fk_id_area'         => $area->id,
            'fk_id_teacher'      => auth()->id(),
            'title_course'       => $data['title_course'],
            'slug_course'        => Str::slug($data['title_course']),
            'public_id'          => Str::uuid(),
            'description_course' => $data['description_course'],
            'duration_course'    => $data['duration_course'],
            'active_course'      => $data['active_course'],
            'url_image_course'   => $path,
        ]);

        return response()->json([
            'message' => 'Curso criado com sucesso.',
            'course'  => new ResourceCourses($course->load('area'))
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $public_id)
    {
        $course = Course::with('area', 'teacher')
            ->where('public_id', $public_id)
            ->first();

        if (!$course) {
            return response()->json([
                'message' => 'Curso não encontrado.',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'course' => new ResourceCoursesShow($course),
            'status' => 200
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $public_id)
    {
        try {
            $data = $request->all();

            $course = Course::where('public_id', $public_id)->firstOrFail();

            if ($request->hasFile('url_image_course')) {
                $path = $request->file('url_image_course')->store('course_image', 'public');
                $data['url_image_course'] = $path;
            }

            $course->update($data);

            return response()->json([
                'message' => 'Curso atualizado com sucesso!',
                'data' => $course
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Erro ao atualizar curso!',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $public_id)
    {
        try {
            $course = Course::where('public_id', $public_id)->firstOrFail();

            $course->delete();

            return response()->json([
                'message' => 'Curso excluído com sucesso'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Curso não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir este curso!',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function showContentCourse(string $public_id)
    {
        $userId = auth()->id();



        $course = Course::where('public_id', $public_id)
            ->with(['classes', 'activities.alternatives'])
            ->firstOrFail();


        $completedClassIds = DB::table('tb_lesson_progress')
            ->where('fk_id_student', $userId)
            ->where('is_completed', true)
            ->whereIn('fk_id_class', $course->classes->pluck('id_class'))
            ->pluck('fk_id_class')
            ->toArray();

        $completedActivityIds = DB::table('tb_student_answers')
            ->where('fk_id_student', $userId)
            ->whereIn('fk_id_activity', $course->activities->pluck('id_activity'))
            ->distinct()
            ->pluck('fk_id_activity')
            ->toArray();

        $totalClasses = $course->classes->count();
        $totalActivities = $course->activities->count();

        $allClassesDone = $totalClasses > 0 && count($completedClassIds) === $totalClasses;
        $allActivitiesDone = $totalActivities === 0 || count($completedActivityIds) === $totalActivities;

        $isCourseCompleted = $allClassesDone && $allActivitiesDone;

        return response()->json(
                new ContentCourseResource($course, $completedClassIds, $completedActivityIds, $isCourseCompleted),
        );
    }

    public function isEnrolled(string $public_id)
    {
        $course = Course::where('public_id', $public_id)->firstOrFail();

        $userId = auth()->id();

        $isEnrolled = $course->students()
            ->where('fk_id_student', $userId)
            ->exists();

        return response()->json([
            'is_enrolled' => $isEnrolled
        ]);
    }
}
