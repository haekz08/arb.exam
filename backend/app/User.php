<?php

namespace App;

use App\Traits\FormatterTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes,FormatterTrait;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'created_by',
        'updated_by',
    ];

    protected $hidden=[
        'password',
        'remember_token',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'formatted_created_at'
    ];


    public function role(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    public function getFormattedCreatedAtAttribute()
    {
        return $this->format_date($this->attributes['created_at']);
    }
}
