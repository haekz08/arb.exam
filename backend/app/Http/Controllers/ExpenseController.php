<?php

namespace App\Http\Controllers;

use App\Constants\Permissions;
use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
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
            $data = Expense::with(['expense_category'])
                ->whereHas('expense_category', function($query) use ($search_key){
                    $query->where('name', 'like', '%'.$search_key.'%');
                })->paginate($this->per_page);
        }else
        {
            $data = Expense::all();
        }
        return response($data);
    }
    public function save(){
        $data = $this->request->all();
        if (isset($data['id']) && $data['id'] != -1) {
            $data['updated_by'] = $this->getUserId();
        } else {
            $data['created_by'] = $this->getUserId();
            $data['updated_by'] = $this->getUserId();
        }
        $permission = new PermissionController($this->request);
        if(!$permission->check(Permissions::expense_crud))
            return response('Invalid Access',422);
        DB::beginTransaction();
        try
        {
            $result = Expense::updateOrCreate(['id'=>$data['id']],$data);
            DB::commit();
            return empty($result) ? response('Internal Server Error',500) : response($result,200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
    }
    public function delete(){
        $permission = new PermissionController($this->request);
        if(!$permission->check(Permissions::expense_crud))
            return response('Invalid Access',422);
        $data = $this->request->all();
        $result = Expense::find( $data['id'] );
        $result->updated_by = $this->getUserId();
        $result->save();
        $result->delete();
        return empty($result) ? response('Internal Server Error',500) : response('Successfully Deleted Record',200);
    }
    public function get(){
        $data = $this->request->all();
        $result = Expense::find($data['id']);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
}
