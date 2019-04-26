<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlDefinition extends Model
{
    protected $fillable = ['user_id','protocol_id','three_d_id','name','description','json_data'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function protocol()
    {
        return $this->belongsTo(Protocol::class);
    }

    public function three_d()
    {
        return $this->belongsTo(ThreeD::class);
    }

    public function ThreeDOwnedByUser($three_d_id)
    {
        $three_d = ThreeD::find($three_d_id);

        return $three_d && $three_d->user_id == auth()->user()->id;
    }
}
