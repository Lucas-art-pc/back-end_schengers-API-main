<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\StudentCourse;
use App\Models\User;
use Illuminate\Http\Request;

class DataStudents extends Controller
{

    public function countStudents()
    {
        $students = User::count();
        return response()->json([
            'count' => $students,
        ]);
    }
    public function indexStudents(Request $request)
{
    $students = User::query()
        ->orderBy('name')
        ->paginate($request->integer('per_page', 15));

   return response()->json($students);
}

}
