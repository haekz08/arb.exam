<?php

namespace App;

use App\Traits\FormatterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ExpenseCategory extends Model
{
    use SoftDeletes;
    use FormatterTrait;
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $hidden=[
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $appends = [
        'formatted_created_at',
        'total_expenses',
        'grand_total_expenses'
    ];
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id', 'id')->where('created_by',Auth::id());
    }
    public function all_expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id', 'id');
    }
    public function getFormattedCreatedAtAttribute()
    {
        return $this->format_date($this->attributes['created_at']);
    }
    public function getTotalExpensesAttribute(){
        return $this->format_amount($this->expenses->sum('amount'));
    }
    public function getGrandTotalExpensesAttribute(){
        return $this->format_amount($this->all_expenses->sum('amount'));
    }
}
