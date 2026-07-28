<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    //


    protected $table = 'tb_support';

    protected $primaryKey = 'id_support';
    public $timestamps = true;


    protected $fillable = [
        'id_support',
        'public_id',
        'fk_id_sender_user',
        'title_support',
        'message_support',
        'type_support',
        'status_support',
        'issued_at',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'fk_id_sender_user');
    }
}
