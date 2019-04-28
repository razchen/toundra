<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class ThreeD extends Model
{
    protected $fillable = ['user_id','name','description'];
    protected $table = 'three_ds';

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getFiles(ThreeD $three_d)
    {
    	$three_d->files = DB::table('three_d_files')->where('three_d_id',$three_d->id)->get();
    }
}
