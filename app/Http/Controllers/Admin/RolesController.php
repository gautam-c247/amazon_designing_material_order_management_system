<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleAndService\CreateRoleRequest;
use App\Services\Admin\Role\RolesService;
use App\Traits\ResponseCodeTrait;
use Exception;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    use ResponseCodeTrait;
    protected $rolesService;
    public function __construct(RolesService $rolesService)
    {
        $this->rolesService = $rolesService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->rolesService->getRoles();
        return $this->getResponseCode(code: 200, message: "Roles fetched successfully", data: $roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $data = $request->validated();
        try {
            $this->rolesService->createRole($data);
            return $this->getResponseCode(code: 201, message: 'Role update successfully');
        } catch (Exception $e) {
            return $this->getResponseCode(code: 500, message: 'Failed to udpate role', error: $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->rolesService->delete($id);
            return $this->getResponseCode(code: 201, message: 'Role deleted successFully');
        } catch (Exception $e) {
            return $this->getResponseCode(code: 500, message: 'failed to delete role', error: $e->getMessage());
        }
    }

    public function getPermission()
    {
        $permissions = $this->rolesService->getPermissions();
        $this->getResponseCode(code: 200, data: $permissions);
    }
}
