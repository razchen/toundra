<?php

namespace App;
use App\ControlDefinition;
use DB;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['instance_id','control_definition_id', 'json_data', 'active'];

    public function control_definition()
    {
    	return $this->belongsTo(ControlDefinition::class);
    }

    public static function getAllReports()
    {
        $filters = filtersAllowed(['instance_id']);
        sortAllowed();

        $reports = DB::table('reports as r')
        ->select('r.*')
        ->leftjoin('control_definitions as c','c.id','=','r.control_definition_id')
        ->where($filters)
        ->orderBy(request()->get('sort'),request()->get('sort_dir'))
        ->get();
        
        return $reports;
    }

    public static function getAllAuthReports()
    {
        $filters = filtersAllowed(['instance_id']);
        sortAllowed();

        $reports = DB::table('reports as r')
        ->select('r.*')
        ->leftjoin('control_definitions as c','c.id','=','r.control_definition_id')
        ->where('c.user_id',auth()->user()->id)
        ->where($filters)
        ->orderBy(request()->get('sort'),request()->get('sort_dir'))
        ->get();
        
        return $reports;
    }

    public function controlDefinitionOwnedByUser($control_definition_id)
    {
        $control_definition = ControlDefinition::find($control_definition_id);

        return $control_definition && $control_definition->user_id == auth()->user()->id;
    }
}
