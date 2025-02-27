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
     * Retrieve a paginated list of users with filtering, searching, and ordering capabilities.
     *
     * This method fetches user data along with their associated user details
     * while excluding the currently authenticated user. The data can be filtered
     * by status and gender, searched by name or email, and ordered by specified
     * user detail fields. Pagination is applied based on the 'per_page' request parameter.
     *
     * @param \Illuminate\Http\Request $request The request object containing search, filter, and pagination parameters.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of users.
     */

    public function index($request)
    {
        $query = User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.status',
            'users.created_at',
            'user_details.gender',
            'user_details.date_of_birth',
            'user_details.contact_no',
            'user_details.location',
            'user_details.profile_picture',
            'user_details.id as user_details_id'
        )
            ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
            ->where('users.id', '!=', Auth::id());

        // Add search conditions
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('users.name', 'like', '%' . $request->search . '%')
                    ->orWhere('users.email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('users.status', $request->status);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->whereHas('userDetails', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }
        // Apply ordering
        if ($request->has('order_by') && $request->has('order')) {
            $allowedColumns = (new UserDetail())->getFillable();
            if (in_array($request->order_by, $allowedColumns)) {
                $query->orderBy('user_details.' . $request->order_by, $request->order);
            }
        }
        // Pagination
        return $query->paginate($request->input('per_page', config('admin.per_page')));
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
        $userData = array_intersect_key($data, array_flip(['name', 'password', 'email']));
        $userDetails = array_intersect_key($data, array_flip(['gender', 'date_of_birth', 'contact_no', 'location', 'profile_picture','country_code']));
        DB::beginTransaction();
        try {
            if (isset($userDetails['profile_picture'])) {
                $userDetails['profile_picture'] = Storage::disk('public')->put('uploads', $userDetails['profile_picture']);
            }
            $userData['password'] = Hash::make('Codebank@' . rand(0000, 9999));
            $user = User::create($userData);
            if ($user) {
                $user->userDetails()->create($userDetails);
            } else {
                DB::rollBack();
                throw new Exception('User not created');
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    /**
     * Updates a user.
     *
     * @param int $userId The user's ID
     * @param array $data The input data
     * @return User The updated user
     * @throws \Exception
     */
    public function update($userId, $data)
    {
        $data = array_filter($data, function ($value) {
            return $value !== null;
        });
        $userData = array_intersect_key($data, array_flip(['name', 'password', 'email']));
        $userDetails = array_intersect_key($data, array_flip(['gender', 'date_of_birth', 'contact_no', 'location', 'profile_picture','country_code']));

        DB::beginTransaction();
        try {
            $user = User::findOrFail($userId);
            if (isset($userDetails['profile_picture'])) {
                if ($user->userDetails?->profile_picture) {
                    Storage::disk('public')->delete('uploads/' . $user->userDetails?->profile_picture);
                }
                $userDetails['profile_picture'] = Storage::disk('public')->put('uploads', $userDetails['profile_picture']);
            }
            $user->update($userData);
            if ($userDetails) {
                $user->userDetails()->updateOrCreate(
                    ['user_id' => $user->id],
                    $userDetails
                );
            }
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
        return User::with('userDetails')->findOrFail($userId);
    }
    public function changeStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = $user->status == 1 ? '0' : '1';
        $user->save();
    }
}
