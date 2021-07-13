<?php

namespace App;

use App\Traits\FormatterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    use FormatterTrait;
    protected $fillable = [
        'description',
        'permission_code',
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
        'is_selected'
    ];
    protected $casts = [
        'is_selected'=>'boolean'
    ];
    public function getIsSelectedAttribute(){
        return false;
    }
}
