<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    //

    protected $table = 'tb_lesson_progress';

    protected $fillable = [
        'fk_id_student',
        'fk_id_class',
        'is_completed',
        'completed_at'
    ];

    // Relacionamentos
    public function student()
    {
        return $this->belongsTo(User::class, 'fk_id_student');
    }

    public function lesson()
    {
        return $this->belongsTo(ClassCourse::class, 'fk_id_lesson'); // ajuste o nome
    }
}
