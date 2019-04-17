<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $fillable = ['user_id','name','intrinsic'];

    public function owner()
    {
    	return $this->belongsTo(User::class);
    }
}
