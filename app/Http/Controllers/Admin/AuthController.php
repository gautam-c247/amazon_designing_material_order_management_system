<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Traits\ResponseCodeTrait;
use App\Services\Admin\AuthService;
use App\Http\Requests\Admin\Auth\{ChangePassword, LoginRequest, ResetPassword, UpdateProfile, UpdateProfileImage};

class AuthController extends Controller
{
    use ResponseCodeTrait;
    protected $authService;
    /**
     * Create a new controller instance.
     *
     * @param  AuthService  $authService
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Display the login view for the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Admin\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * This method validates the incoming request (email and password fields are already validated in the LoginRequest)
     * and attempts to log the user in. If the attempt is successful, it redirects the user to the intended route
     * (usually the dashboard) with a success message. If the attempt fails, it redirects the user back to the login
     * page with an error message and the input values.
     */
    public function login(LoginRequest $request)
    {
        // Validate the incoming request (email and password fields are already validated in the LoginRequest)
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');  // Check if the "remember me" option is selected
        // Attempt to log the user in
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();  // Get the authenticated user
            return redirect()->intended(route('admin.dashboard'))->with(['success' => __('validation_messages.login.success')]);
        } else {
            return redirect()->back()->withInput()->with(['error' => __('validation_messages.login.password.incorrect')]);
        }
    }

    /**
     * Display the forgot password view for the admin panel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function forgotPassword(Request $request)
    {
        return view('admin.auth.forgot-password');
    }
    /**
     * Handle a password reset request.
     *
     * @param ResetPassword $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * This method attempts to send a password reset link to the user's email address.
     * It uses the AuthService to perform the action and returns a JSON response with
     * a success message and data if the operation is successful. If an error occurs,
     * it catches the exception and returns a JSON response with an error message.
     */
    public function resetPassword(ResetPassword $request)
    {
        $email = $request->input('email');
        try {
            $res = $this->authService->resetPassword($email);
            return redirect()->back()->with(['success' => __('validation_messages.forgot_password.email.sent')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /**
     * Display the change password view for the admin panel.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     *
     * This method returns the view for the change password page of the admin panel.
     */
    public function editPassword(Request $request)
    {
        return view('admin.profile.change-password')->render();
    }

    /**
     * Change the password for the authenticated user.
     *
     * @param ChangePassword $request The request containing the old and new passwords.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     *
     * This method retrieves the old and new passwords from the request, and attempts
     * to change the user's password using the AuthService. If successful, it returns
     * a JSON response with a success message. If an error occurs, it catches the exception
     * and returns a JSON response with an error message and relevant error details.
     */
    public function changePassword(ChangePassword $request)
    {
        $old_password = $request->input('old_password');
        $new_password = $request->input('password');
        try {
            $res = $this->authService->changePassword($old_password, $new_password);
            return $this->getResponseCode(code: 200, message: __('validation_messages.change_password.success'));
        } catch (\Exception $e) {
            $errors = ["old_password" => [$e->getMessage()]];
            return $this->getResponseCode(code: $e->getCode(), message: $e->getMessage(), error: $e->getMessage(), errors: $errors);
        }
    }
    /**
     * Display the edit profile view for the admin panel.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     *
     * This method returns the view for editing the authenticated user's profile.
     */
    public function editProfile(Request $request)
    {
        return view('admin.profile.edit-profile');
    }
    /**
     * Update the authenticated user's profile information.
     *
     * @param UpdateProfile $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This method handles the request to update the user's profile information.
     * It validates the request data and uses the AuthService to update the profile.
     * On success, it returns a JSON response with a success message and updated data.
     * In case of an error, it catches the exception and returns a JSON response with an error message.
     */
    public function updateProfile(UpdateProfile $request)
    {

        $data = $request->validated();

        try {
            $res = $this->authService->updateProfile($data);

            return response()->json([
                'success' => true,
                'message' => __('validation_messages.profile.success'),
                'data' => [
                    'name' => $data['name'],
                    'email' => auth()->user()->email,
                    'contact_no' => $data['contact_no'],
                    'country_code' => $data['country_code'],
                    'location' => $data['location'],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('validation_messages.profile.failed'),
            ]);
        }
    }

    /**
     * Display the profile view for the authenticated user.
     *
     * This method retrieves the user's profile data using the AuthService
     * and returns the profile view with the data and a title.
     *
     * @return \Illuminate\View\View
     */

    public function profile()
    {
        $res = $this->authService->profile();
        return view('admin.profile.profile', ['data' => $res]);
    }
    /**
     * Update the authenticated user's profile picture.
     *
     * This method validates the request data using the UpdateProfileImage request object
     * and uses the AuthService to update the profile picture. If the operation is
     * successful, it returns a JSON response with a 200 status code and a success message.
     * If an error occurs, it catches the exception and returns a JSON response with a 500
     * status code and an error message.
     *
     * @param UpdateProfileImage $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfilePicture(UpdateProfileImage $request)
    {
        $data = $request->validated();
        try {
            $res = $this->authService->updateProfile($data);
            return $this->getResponseCode(
                code: 200,
                message: __('validation_messages.edit_profile.picture_update_success'),
                data: $res
            );
        } catch (\Exception $e) {
            return $this->getResponseCode(
                code: 500,
                message: $e->getMessage(),
                error: $e->getMessage()
            );
        }
    }

    /**
     * Delete the authenticated user's profile picture.
     *
     * This method uses the AuthService to delete the user's profile picture.
     * If the operation is successful, it returns a JSON response with a 201 status code and a success message.
     * If an error occurs, it catches the exception and throws a new Exception with the error message.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteProfilePicture()
    {
        try {
            $res = $this->authService->deleteProfilePicture();
            return $this->getResponseCode(code: 201, message: __('validation_messages.edit_profile.picture_delete_success'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->back();
    }
}
