<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = ['name','description','json_data'];
}
