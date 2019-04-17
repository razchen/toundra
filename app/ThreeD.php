<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreeD extends Model
{
    protected $fillable = ['user_id','name','point_of_view'];
    protected $table = 'three_ds';

    // public function tasks()
    // {
    // 	return $this->hasMany(Task::class);
    // }

    // public function addTask($task)
    // {
    // 	$this->tasks()->create($task);
    // }

    public function owner()
    {
    	return $this->belongsTo(User::class);
    }
}
