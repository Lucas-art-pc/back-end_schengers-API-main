<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityProgress extends Model
{
    //

    protected $table = 'tb_activity_progress';

    protected $fillable = [
        'fk_id_student',
        'fk_id_activity',
        'is_completed',
        'completed_at'
    ];

    // Relacionamentos
    public function student()
    {
        return $this->belongsTo(User::class, 'fk_id_student');
    }

    public function activity()
    {
        return $this->belongsTo(ActivityCourse::class, 'fk_id_activity'); // ajuste o nome
    }
}
