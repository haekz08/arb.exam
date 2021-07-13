<?php

namespace App;

use App\Traits\FormatterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;
    use FormatterTrait;
    protected $fillable = [
        'expense_category_id',
        'amount',
        'entry_date',
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
        'formatted_entry_date',
        'formatted_amount'
    ];

    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }
    public function getFormattedCreatedAtAttribute()
    {
        return $this->format_date($this->attributes['created_at']);
    }
    public function getFormattedEntryDateAttribute()
    {
        return $this->format_date($this->attributes['entry_date']);
    }
    public function getFormattedAmountAttribute()
    {
        return $this->format_amount($this->attributes['amount']);
    }
}
