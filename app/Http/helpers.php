<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;


function getMailTypes(): array
{
    return ['registered' => 'Registered', 'completed' => 'Completed', 'rejected' => 'Rejected', 'forwarded' => 'Forwarded'];
}


function getStatus($status): string
{
    return match ($status) {
        '1' => '<span class="badge badge-info label label-info">Active</span>',
        '2' => '<span class="badge badge-primary label label-primary">Approved</span>',
        default => '<span class="badge badge-danger label label-danger">Rejected</span>',
    };
}

function getRoles($status): string
{
    return '<span class="badge badge-primary">  ' . $status . '</span>';
}

function ufirst($value): string
{
    return str_replace('_', ' ', ucwords($value, '_'));

}

function dropColumnIfExists($table_name, $column_name)
{
    if (Schema::hasColumn($table_name, $column_name)) //check the column
        Schema::table($table_name, function (Blueprint $table) use ($column_name) {
            $table->dropColumn($column_name);
        });
}

function alterColumnIfNotExists($table_name, $column_name, $type, $nullable = false)
{
    if (!Schema::hasColumn($table_name, $column_name)) //check the column
        Schema::table($table_name, function (Blueprint $table) use ($column_name, $type, $nullable) {
            $row = $table->{$type}($column_name);
            if ($row)
                $row->nullable();
        });
}


function isSuperAdmin()
{
    return auth()->user()->isSuperAdmin();
}


function isLocalEnvironment(): bool
{
    return App::environment(['local', 'staging']);
}


function same($value1, $value2): bool
{
    return strtolower($value1) == strtolower($value2);
}



function usplit($string)
{

    $str_array = preg_split('/\B(?=[A-Z])/s', $string);
    $val = '';
    foreach ($str_array as $value) {
        $val .= $value . " ";
    }
    return $val;
}

function hasPermission($permission): bool
{
    if (!is_null($permission)) {
        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);
    }
    if (is_null($permission)) {
        $permission = request()->route()->getName();
        $permissions = array($permission);
    }
    foreach ($permissions as $permission)
        if (auth()->user()->can($permission))
            return true;
    return false;
}

function storage_file_path($path): string
{
    return storage_path('app/public/' . $path);
}


function baseClassName($model): string
{
    return class_basename($model);
}

