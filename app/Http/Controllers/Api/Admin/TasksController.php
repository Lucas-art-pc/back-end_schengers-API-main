<?php


namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;


use App\Http\Requests\TaskRequest;
use App\Models\Tasks;
use App\Models\Teacher;
use Illuminate\Http\Request;


class TasksController extends Controller
{
    public function indexByTeacher()
    {
        $idTeacher = auth()->id();
        $tasks = Tasks::where('fk_id_teacher', $idTeacher)
            ->orderBy('completed_task', 'desc')
            ->orderBy('send_date', 'desc')
            ->get();


        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'Nenhuma tarefa encontrada.',
            ]);
        }


        return response()->json([
            'data' => $tasks
        ]);
    }
    //
    public function store(TaskRequest $request, string $public_id)
    {
        $teacher = Teacher::where('public_id', $public_id)->first();


        $taskData = $request->validated();


        Tasks::create([
            ...$taskData,
            'fk_id_teacher' => $teacher->id,
            'completed_task' => false
        ]);


        return response()->json([
            'message' => 'Mensagem enviada com sucesso!'
        ]);
    }


    public function show(string $public_id){
        $task = Tasks::where('public_id', $public_id)->first();


        if (!$task) {
            return response()->json([
                'message' => 'Nenhuma tarefa encontrada.',
            ]);
        }
        return response()->json([
            'data' => $task
        ]);
    }
}


