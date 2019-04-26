<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreeD extends Model
{
    protected $fillable = ['user_id','name','description'];
    protected $table = 'three_ds';

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
