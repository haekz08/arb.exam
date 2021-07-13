<?php

namespace App\Http\Controllers;

use App\Constants\Permissions;
use App\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
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
            $data = ExpenseCategory::where('name', 'like', '%'.$this->search.'%')->orWhere('description', 'like', '%'.$this->search.'%')->paginate($this->per_page);
        }else
        {
            $data = ExpenseCategory::with(['expenses'])->get();
        }
        return response($data);
    }
    public function save(){

        $data = $this->request->all();
        if (isset($data['id']) && $data['id'] != -1) {
            $validate = ExpenseCategory::where('name',$data['name'])
                ->where('id','!=',$data['id'])
                ->first();
            if($validate)
                return response('Expense Category name already exists.',422);
            $data['updated_by'] = $this->getUserId();
        } else {
            $validate = ExpenseCategory::where('name',$data['name'])
                ->first();
            if($validate)
                return response('Expense Category name already exists.',422);
            $data['created_by'] = $this->getUserId();
            $data['updated_by'] = $this->getUserId();


        }

        $permission = new PermissionController($this->request);
        if(!$permission->check(Permissions::expense_category_crud))
            return response('Invalid Access',422);
        DB::beginTransaction();
        try
        {
            $result = ExpenseCategory::updateOrCreate(['id'=>$data['id']],$data);
            DB::commit();
            return empty($result) ? response('Internal Server Error',500) : response($result,200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
    }
    public function delete(){
        $permission = new PermissionController($this->request);
        if(!$permission->check(Permissions::expense_category_crud))
            return response('Invalid Access',422);
        $data = $this->request->all();
        $result = ExpenseCategory::find( $data['id'] );
        $result->updated_by = $this->getUserId();
        $result->save();
        $result->delete();
        return empty($result) ? response('Internal Server Error',500) : response('Successfully Deleted Record',200);
    }
    public function get(){
        $data = $this->request->all();
        $result = ExpenseCategory::find($data['id']);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
}
