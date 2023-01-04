<?php

namespace App\Models;

use App\Traits\Search\BasicFilter;

class Role extends \Spatie\Permission\Models\Role
{
    use BasicFilter;

    const TEACHER = 'Teacher';
    const STUDENT = 'Student';
    protected $fillable = ['name', 'guard_name'];
    protected array $searchAttributes = ['name'];
}
