<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    protected $request;
    protected $search='';
    protected $per_page;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->per_page = isset($request->per_page) ? $request->per_page : $this->per_page;
        $this->search = isset($request->search) ? $request->search : $this->search;
    }
    public function getUserId(){
        return Auth::id();
    }
    public function all(){
        $data = Permission::all();
        return response($data);
    }
    public function check($permission_id){
        $is_allowed = DB::table('role_permissions')->where('permission_id', $permission_id)->where('role_id', Auth::user()->role_id)->first();
        return ($is_allowed) ? true : false;
    }
}
