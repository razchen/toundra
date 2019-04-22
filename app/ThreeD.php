<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreeD extends Model
{
    protected $fillable = ['user_id','name','description'];
    protected $table = 'three_ds';

    public function owner()
    {
    	return $this->belongsTo(User::class);
    }
}
