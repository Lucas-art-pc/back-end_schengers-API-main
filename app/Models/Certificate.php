<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
protected $table = 'tb_certificates';

    protected $fillable = [
        'public_id',
        'fk_id_student',
        'fk_id_course',
        'hash',
        'issued_at',
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
