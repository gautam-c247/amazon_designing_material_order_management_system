<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;

use App\Traits\ResponseCodeTrait;
use App\Http\Controllers\Controller;
use App\Services\Admin\UserManagementService;
use App\Http\Requests\Admin\UserManagement\{CreateUserRequest, UpdateUserRequest};

class UserManagementController extends Controller
{
    use ResponseCodeTrait;
    protected $userManagementService;

    /**
     * Constructor
     *
     * @param UserManagementService $userManagementService The user management service instance to inject.
     */

    public function __construct(UserManagementService $userManagementService)
    {
        $this->userManagementService = $userManagementService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request The input HTTP request object.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse The rendered view when the request is not an AJAX request, otherwise a JSON response.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $users = $this->userManagementService->index($request);
            return $this->getResponseCode(code: 200, message: __('users.fetch_success', ['attribute' => 'Users']), data: $users);
        }
        return view('admin.user.index');
    }

    /**
     * Display the create user form.
     *
     * @return \Illuminate\View\View The rendered create user form view.
     */
    public function create()
    {
        return view('admin.user.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UserManagement\CreateUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        try {
            $user = $this->userManagementService->store($data);
            return $this->getResponseCode(code: 201, message: __('users.create_success', ['attribute' => 'User']));
        } catch (\Exception $e) {
            return $this->getResponseCode(code: 400, message: $e->getMessage(), error: $e->getMessage());
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, string $id)
    {

        try {
            $user = $this->userManagementService->edit($id);
            return view('admin.user.create', compact('user'))->render();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }
/**
 * Update the specified user resource in storage.
 *
 * @param UpdateUserRequest $request The request object containing the update data.
 * @param int $id The ID of the user to be updated.
 * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure of the update operation.
 *
 * This method attempts to update the user details using the UserManagementService.
 * It validates the request data and handles exceptions, returning appropriate
 * success or error messages in the response.
 */

    public function update(UpdateUserRequest $request, int $id)
    {
        // use validated function to remove csrf input field and other unwanted fields
        $data  = $request->validated();
         try {
                $res = $this->userManagementService->update($id, $data);
                return $this->getResponseCode(code: 200, message: __('users.update_success', ['attribute' => 'Users']));
            } catch (Exception $e) {
                return $this->getResponseCode(500, message: __('users.update_failed', ['attribute' => 'User']), error: $e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $res = $this->userManagementService->destroy($id);
            return $this->getResponseCode(code: 200, message: __('users.delete_success', ['attribute' => 'User']));
        } catch (Exception $e) {
            return $this->getResponseCode(500, message: __('users.delete_failed', ['attribute' => 'User']), error: $e->getMessage());
        }
    }
    public function changeStatus(Request $request, string $id)
    {
        try {
            $res = $this->userManagementService->changeStatus($id);
            return $this->getResponseCode(code: 200, message: __('users.status_change_success'));
        } catch (Exception $e) {
            return $this->getResponseCode(500, message: __('users.failed_change_status'), error: $e->getMessage());
        }
    }
}
