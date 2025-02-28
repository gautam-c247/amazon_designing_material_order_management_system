<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserManagementService
{
    /**
     * Retrieves a paginated list of users with optional search and filter criteria.
     *
     * This method allows filtering users by name or email using the 'search' parameter
     * and filtering by status if the 'status' parameter is provided. It also includes
     * user roles in the response.
     *
     * @param \Illuminate\Http\Request $request The request object containing search and filter criteria
     * @return \Illuminate\Pagination\LengthAwarePaginator A paginated list of users
     */

    public function index($request)
    {
        $query = User::select('name','email','id','created_at','status')->with(['roles' => function($q){
            $q->select('id', 'name');
        }]);
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('users.name', 'like', '%' . $request->search . '%')
                    ->orWhere('users.email', 'like', '%' . $request->search . '%');
            });
        }
        // filter by status
        if ($request->filled('status')) {
            $query->where('users.status', $request->status);
        }
        // filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        $users = $query->paginate($request->input('per_page', config('admin.per_page')));
        return $users;
    }

    /**
     * Creates a new user.
     *
     * @param object $data The input data object
     * @return User The newly created user
     * @throws \Exception
     */
    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $role = $data['role'];
            unset($data['role']);
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $user->assignRole($role);
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    /**
     * Updates an existing user with new data and assigns a role.
     *
     * @param int $userId The ID of the user to update
     * @param array $data An associative array of user data including role
     * @return User The updated user object
     * @throws \Exception If the update operation fails
     */

    public function update($userId, $data)
    {
        DB::beginTransaction();
        try {
            $role = $data['role'];
            unset($data['role']);
            $user = User::findOrFail($userId);
            $user->update($data);
            $user->assignRole($role);
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    /**
     * Deletes a user.
     *
     * @param int $userId The user's ID
     *
     * @return bool True if the user was successfully deleted
     * @throws \Exception
     */
    public function destroy($userId)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrfail($userId);
            if ($user->hasRole('admin')) {
                throw new Exception('Cannot delete admin user');
            }
            $user->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function edit($userId)
    {
        return User::with('roles')->findOrFail($userId);
    }
    public function changeStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = $user->status == 1 ? '0' : '1';
        $user->save();
    }
}
