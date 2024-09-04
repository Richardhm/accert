<?php

namespace App\Models\Traits;

use App\Models\Cargo;
use App\Models\Permission;

trait UserACLTrait
{
    public function permissionsACL()
    {
        $permissionsArray = [];
        // Obter permissões por cargo
        $permissions = $this::where("id", auth()->user()->id)
            ->with(['cargo','cargo.permissions'=>function($query) {
                $query->where('corretora_id', $this->corretora_id);
            }])->first();





        foreach ($permissions->cargo->permissions as $p) {
            $permissionsArray[] = $p->name;
        }

        // Obter permissões por corretora
        $corretoraPermissions = Permission::whereHas('corretoras', function ($query) {
            $query->where('corretoras.id', auth()->user()->corretora_id);
        })->get();



        foreach ($corretoraPermissions as $p) {
            $permissionsArray[] = $p->name;
        }


        return $permissionsArray;
    }

    public function hasPermission(string $permissionName)
    {
        return in_array($permissionName, $this->permissionsACL());
    }

    public function isAdmin()
    {
        return in_array($this->email, config('acl.admins'));
    }
}
