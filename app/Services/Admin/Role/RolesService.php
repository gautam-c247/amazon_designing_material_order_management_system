<?php

namespace App\Services\Admin\Role;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\{Permission, Role};
use Exception;

class RolesService
{
    /**
     * Get all permissions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPermissions()
    {
        return Permission::select('name', 'guard_name', 'id')->get();
    }
    /**
     * Create a new role.
     *
     * @param  array  $data
     * @return bool
     *
     * @throws \Exception
     */
    public function createRole($data)
    {
        $role = $data['name'];
        $permissions = $data['permissions'];

        DB::beginTransaction();
        try {
            $role = Role::firstOrCreate(['name' => $role]);
            $permissions = Permission::whereIn('id', $permissions)->get();
            $role->syncPermissions($permissions);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    /**
     * Retrieve all roles with their associated permissions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRoles()
    {
        return Role::with('permissions:id,name')
            ->get(['id', 'name']);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $role = Role::findOrfail($id);
            $role->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
