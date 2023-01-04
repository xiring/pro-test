<?php


namespace App\Http\Services;


use Illuminate\Support\Collection;

class GlobalServices
{
    public function getTotalPermissions(): array
    {
        $array = [];
        $permission = ['view', 'edit', 'create', 'delete'];
        $classes = $this->getAllPermissions();
        foreach ($permission as $item)
            foreach ($classes as $class)
                $array[]['name'] = $class . '-' . $item;
        return $array;
    }

    public function getAllPermissions(): Collection
    {
//        $backend_permissions = collect($this->getPermissionNameViaModel());
        $backend_permissions = collect();
        $other_permissions = collect($this->getOtherPermissions());
        return $backend_permissions->merge($other_permissions);
    }

    private function getOtherPermissions(): array
    {
        return [
            'question',
            'exam'
        ];
    }

}
