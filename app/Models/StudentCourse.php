<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    //

protected $table = 'tb_rel_student_course';

    protected $fillable = [
        'fk_id_student',
        'fk_id_course',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'fk_id_student', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'fk_id_course', 'id_course');
    }
}
