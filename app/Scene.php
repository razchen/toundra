<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Camera;

class Scene extends Model
{
    protected $fillable = ['user_id','camera_id','name','transforms','active'];

    public function owner()
    {
    	return $this->belongsTo(User::class);
    }

    public function cameraOwnedByUser($camera_id)
    {
        return Camera::find($camera_id);
    }

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}
