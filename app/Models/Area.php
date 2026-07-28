<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Area extends Model
{
    //

    protected $table = 'tb_areas';

    protected $fillable = [
        'id',
        'name_area',
        'slug_area',
        'color_area',
    ];

    public $timestamps = true;

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }

    protected static function booted()
    {
        static::saving(function ($model) {

            if ($model->isDirty('name_area')) {
                $model->slug_area = Str::slug($model->name_area);
            }
        });
    }

}
