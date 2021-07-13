<?php

namespace App\Http\Controllers;

use App\Constants\Permissions;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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
        if(isset($this->request->per_page))
        {
            $data = Role::where('name', 'like', '%'.$this->search.'%')->orWhere('description', 'like', '%'.$this->search.'%')->paginate($this->per_page);
        }else
        {
            $data = Role::all();
        }
        return response($data);
    }
    public function save(){
        $data = $this->request->all();

        if (isset($data['id']) && $data['id'] != -1) {
            $validate = Role::where('name',$data['name'])
                ->where('id','!=',$data['id'])
                ->first();
            if($validate)
                return response('Role name already exists.',422);
            $data['updated_by'] = $this->getUserId();
        } else {
            $validate = Role::where('name',$data['name'])
                ->first();
            if($validate)
                return response('Role name already exists.',422);
            $data['created_by'] = $this->getUserId();
            $data['updated_by'] = $this->getUserId();


        }
        $permission = new PermissionController($this->request);
        if(!$permission->check(Permissions::role_crud) || $data['id']==1)
            return response('Invalid Access',422);

        DB::beginTransaction();
        try
        {
            $result = Role::updateOrCreate(['id'=>$data['id']],$data);
            $permission_ids = collect($data['permissions'])->where('is_selected','=','true')->pluck('id')->toArray();
            if(empty($permission_ids))
                return response('No permission/s selected.',422);
            $result->permissions()->sync($permission_ids);

            DB::commit();
            return empty($result) ? response('Internal Server Error',500) : response($result,200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
    }
    public function delete(){
        $data = $this->request->all();

        $permission = new PermissionController($this->request);
        if(!$permission->check(Permissions::role_crud) || $data['id']==1)
            return response('Invalid Access',422);

        $result = Role::find( $data['id'] );
        $result->updated_by = $this->getUserId();
        $result->save();
        $result->delete();
        return empty($result) ? response('Internal Server Error',500) : response('Successfully Deleted Record',200);
    }
    public function get(){
        $data = $this->request->all();
        $role = Role::with('permissions')->find($data['id']);
        $permissions = Permission::all()->toArray();
        foreach($permissions as  $key=>$row_permission){
            $check = collect($role['permissions'])->where('id',$row_permission['id'])->first();
            if($check){
                $permissions[$key]['is_selected'] = true;
            }
        }
        $result = ['role'=>$role,'permissions'=>$permissions];
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
}
