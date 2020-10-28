<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $casts = [
        "date" => "date:Y-m-d",
        "time" => "date:H:i",
        "duration" => "date:H:i"
    ];


    protected $fillable = ['name', 'type_id', 'place', 'date', 'time', 'duration', 'comment', 'done', 'user_id'];
    protected $visible = ['id', 'name', 'place', 'date', 'time', 'duration', 'comment', 'type', 'done', 'user_id'];

    protected $hidden = ["created_at", "updated_at"];
    protected $with = ['type'];

    public function type() {
        return $this->belongsTo('App\Models\TaskType');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    protected static function boot()
    {
        parent::boot();

        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }

}

