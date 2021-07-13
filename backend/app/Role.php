<?php

namespace App;

use App\Traits\FormatterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
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
        'formatted_created_at'
    ];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }
    public function getFormattedCreatedAtAttribute()
    {
        return $this->format_date($this->attributes['created_at']);
    }
}
