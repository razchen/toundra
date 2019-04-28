<?php

namespace App;
use App\ControlDefinition;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['instance_id','control_definition_id'];

    public function control_definition()
    {
    	return $this->belongsTo(ControlDefinition::class);
    }

    public function controlDefinitionOwnedByUser($control_definition_id)
    {
        $control_definition = ControlDefinition::find($control_definition_id);

        return $control_definition && $control_definition->user_id == auth()->user()->id;
    }
}
