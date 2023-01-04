<?php

namespace App\Models;

use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, BasicFilter;


    /**
     * Super User
     */
    const SUPER_ADMIN = 'Teacher';

    /**
     * @var string
     */
    protected string $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $appends = ['role_id'];


    /**
     * @return bool
     */
    public function isSuper(): bool
    {
        return $this->getAttribute('user_type') == 'teacher';
    }

    /**
     * @return int
     */
    public function getRoleIdAttribute()
    {
        return $this->roles ? $this->roles->first()->id : 0;
    }

    public function getUserRoles()
    {
        return $this->roles ? $this->roles[0]->name : "";
    }
}
