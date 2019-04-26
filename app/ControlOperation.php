<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scene;

class ControlOperation extends Model
{
    protected $fillable = ['id', 'operator_name', 'instance_id','user_id', 'scene_id'];

    public function owner()
    {
    	return $this->belongsTo(User::class);
    }

    public function sceneOwnedByUser($scene_id)
    {
        return Scene::find($scene_id);
    }

    public function scene()
    {
        return $this->belongsTo(Scene::class);
    }
}
