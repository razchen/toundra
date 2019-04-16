<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Redirect;
use App\AdminNotification;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function showView()
    {
        return view('admin-pages.users');
    }
    
	public function index()
	{
		$filters = array();

        $filter_list = array(
            'Id' => 'u.id',
            'First Name' => 'u.first_name',
            'Last Name' => 'u.last_name',
            'Email' => 'u.email',
            'Type' => 'u.type',
            'Username' => 'u.username',
            'IP Address' => 'i.ip_address',
            'Confirmed' => 'u.confirmed',
            'Created' => 'u.created_at',
        );

        foreach ($filter_list as $filter => $table_join_column) {
            $filter_name = strtolower(str_replace(' ','-',$filter));
            if (Input::get($filter_name) != '') {
                $filters[$filter] = trim(Input::get($filter_name));
            }
        }

        $users = DB::table('users AS u')
            ->select('u.id','u.email','u.first_name','u.last_name','c.country',
            'u.username','u.gender','u.birthday','u.description','u.website',
            'guide_views','u.confirmed','u.profile_picture','u.created_at')
            ->leftjoin('ips AS i','i.id','=','u.ip_id')
            ->leftjoin('countries AS c','c.id','=','i.country_id');

        if ($filter_list) {
            foreach ($filter_list as $filter => $table_join_column) {
                $filter_name = strtolower(str_replace(' ','-',$filter));
                $filter_value = Input::get($filter_name);
                if (Input::get($filter_name) != '') {
                    $filters[$filter] = trim(Input::get($filter_name));

                    if ($filter_name == 'start-date' || $filter_name == 'end-date') {
                        $op = '';
                        if ($filter_name == 'start-date') {
                            $op = '>=';
                            $filter_value = date('Y-m-d',strtotime($filter_value)).' 00:00:00';
                        } elseif ($filter_name == 'end-date') {
                            $op = '<=';
                            $filter_value = date('Y-m-d',strtotime($filter_value)).' 23:59:59';
                        }

                        $users = $users->where($table_join_column, $op, $filter_value);
                    } else {
                        $filter_with_wild_card = trim(Input::get($filter_name)).'%';
    

                        $users = $users->where($table_join_column, 'LIKE', $filter_with_wild_card);
                    }
                }
            }
        }

        if (!empty($filter_list[Input::get('sort')])) {
            $sort = $filter_list[Input::get('sort')];
        } else {
            $sort = 'u.created_at';
        }

        if (Input::get('sort-dir')) {
            $sort_dir = Input::get('sort-dir');
        } else {
            $sort_dir = 'desc';
        }

        $users = $users->orderBy($sort, $sort_dir)
            ->simplePaginate(30);

        foreach ($users as $user) {
            $user->created_at = date('d-m-Y H:i:s',strtotime($user->created_at));
        }

		return $users->toJson();
	}

	public function store(UserStoreRequest $request)
	{
		$user = new User;
        $user->email = $request->email ?: '';
        $user->password = bcrypt($request->password);
        $user->username = $request->username ?: '';
        $user->first_name = $request->first_name ?: '';
        $user->last_name = $request->last_name ?: '';
        $user->gender = $request->gender ?: 'male';
        $user->birthday = $request->birthday ? date('Y-m-d',strtotime($request->birthday)): '';
        $user->description = $request->description ?: '';
        $user->website = $request->website ?: '';
        $user->guide_views = $request->guide_views ?: '';
        $user->confirmed = $request->confirmed ?: 0;
        $user->banned = $request->banned ?: 0;
        $user->ip_id = 0;
        $user->save();

		return response()->json('User created!');
	}

	public function show($id)
	{
		$user = User::FindOrFail($id);

		return $user->toJson();
    }
    
    public function edit($id)
    {
        $user = User::FindOrFail($id);

        return $user->toJson();
    }

    public function update($id, Request $request)
    {
        $user = User::FindOrFail($id);

        $user->email = $request->email ?: '';
        $user->password = bcrypt($request->password);
        $user->username = $request->username ?: '';
        $user->first_name = $request->first_name ?: '';
        $user->last_name = $request->last_name ?: '';
        $user->gender = $request->gender ?: 'male';
        $user->birthday = $request->birthday ? date('Y-m-d',strtotime($request->birthday)): '';
        $user->description = $request->description ?: '';
        $user->website = $request->website ?: '';
        $user->guide_views = $request->guide_views ?: '';
        $user->confirmed = $request->confirmed ?: 0;
        $user->banned = $request->banned ?: 0;
        $user->ip_id = 0;

        $user->save();

        return response()->json('User updated!');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::find($id);

            $user->delete();

            return response()->json('User deleted!');
        }
    }
}
