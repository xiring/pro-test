<?php

namespace App\Repositories;


use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends Repository
{

    public function __construct(protected Model $model)
    {

    }

}
