<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Camera;

class Scene extends Model
{
    protected $fillable = ['user_id','camera_id','name','transforms','active'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function cameraOwnedByUser($camera_id)
    {
        $camera = Camera::find($camera_id);

        return $camera && $camera->user_id == auth()->user()->id;
    }

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}
