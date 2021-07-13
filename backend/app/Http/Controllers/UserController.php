<?php

namespace App\Http\Controllers;

use App\Constants\Permissions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        $search_key=$this->search;
        if(isset($this->request->per_page))
        {
            $data = User::with(['role'])
                ->where('name', 'like', '%'.$search_key.'%')
                ->orWhere('email', 'like', '%'.$search_key.'%')
                ->orWhereHas('role', function($query) use ($search_key){
                    $query->where('name', 'like', '%'.$search_key.'%');
                })->paginate($this->per_page);
        }else
        {
            $data = User::all();
        }
        return response($data);
    }
    public function save(){
        $data = $this->request->all();
        if (isset($data['id']) && $data['id'] != -1) {
            $validate = User::where('email',$data['email'])
                ->where('id','!=',$data['id'])
                ->first();
            if($validate)
                return response('Email Address already exists.',422);
            $data['updated_by'] = $this->getUserId();
            unset($data['password']);
        } else {
            $validate = User::where('email',$data['email'])
                ->first();
            if($validate)
                return response('Email Address already exists.',422);
            $data['created_by'] = $this->getUserId();
            $data['updated_by'] = $this->getUserId();
            $data['password'] = bcrypt($data['password']);
        }

        $permission = new PermissionController($this->request);
        if(!$permission->check(Permissions::user_crud))
            return response('Invalid Access',422);
        DB::beginTransaction();
        try
        {
            $result = User::updateOrCreate(['id'=>$data['id']],$data);
            DB::commit();
            return empty($result) ? response('Internal Server Error',500) : response($result,200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
    }
    public function delete(){
        $permission = new PermissionController($this->request);
        if(!$permission->check(Permissions::user_crud))
            return response('Invalid Access',422);
        $data = $this->request->all();
        $result = User::find( $data['id'] );
        $result->updated_by = $this->getUserId();
        $result->save();
        $result->delete();
        return empty($result) ? response('Internal Server Error',500) : response('Successfully Deleted Record',200);
    }
    public function get(){
        $data = $this->request->all();
        $result = User::find($data['id']);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }

    public function changePassword(){
        $data = $this->request->all();

        if(empty($data['old_password']) || empty($data['new_password']))
            return response('Invalid Action.',422);

        $user = User::find($this->getUserId());

        if (!Hash::check($data['old_password'], $user->password))
        {
            return response('Invalid Old Password.',422);
        }
        DB::beginTransaction();
        try
        {
            $user->password = bcrypt($data['new_password']);
            $user->save();
            DB::commit();
            return response('Success.',200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
    }
}
