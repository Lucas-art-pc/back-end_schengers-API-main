<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //

    protected $table = 'tb_tasks_teacher';
    protected $primaryKey = 'id_task';
    protected $fillable = [
        'fk_id_teacher',
        'public_id',
        'title_task',
        'description_task',
        'deadline_task',
        'date_task',
        'time_task',
        'type_task',
        'completed_task',

    ];

    public $timestamps = true;

    public function teacher(){
        return $this->belongsTo(Teacher::class,'fk_id_teacher');
    }
}
