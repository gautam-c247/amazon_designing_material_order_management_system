<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\ResponseCodeTrait;
use App\Services\Admin\NotificationService;
use App\Http\Requests\Admin\NotificationRequest;

class NotificationController extends Controller
{
    use ResponseCodeTrait;
    protected $notificationService;

    /**
     * NotificationController constructor.
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handles the retrieval of notifications.
     *
     * @param Request $request The input HTTP request object.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     *
     * This method handles the retrieval of notifications. It supports both JSON and non-JSON requests.
     * For JSON requests, it fetches notifications based on pagination, search, order, and status filters.
     * It returns a JSON response with the list of notifications and a success message.
     * For non-JSON requests, it returns the notifications view with a title.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $notifications = $this->notificationService->index($request);
            return $this->getResponseCode(code: 200, data: $notifications, message: __('validation_messages.common.fetch_success', ['attribute' => 'Notifications']));
        } else {
            $title = 'Notifications';
            return view('admin.notification.index', compact('title'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = $this->notificationService->create();
        return view('admin.notification.create', compact('users'));
    }

    public function store(NotificationRequest $request)
    {
        $data = $request->validated();
        try {
            $res = $this->notificationService->store($data);
            return $this->getResponseCode(code: 201, message: __('validation_messages.common.create_success', ['attribute' => 'Notification']));
        } catch (Exception $e) {
            return $this->getResponseCode(code: 500, message: __('validation_messages.common.create_failed', ['attribute' => 'Notification']), error: $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $selectedNotification = $this->notificationService->getNotification($id);
        // dd($selectedNotification->toArray());
        $users = $this->notificationService->create();
        return view('admin.notification.create', compact('selectedNotification', 'users'))->render();
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationRequest $request, string $id)
    {
        $data = $request->validated();
          try {
            $res = $this->notificationService->update($id, $data);
            return $this->getResponseCode(code: 201, message: __('validation_messages.common.update_success', ['attribute' => 'Notification']));
        } catch (Exception $e) {
            return $this->getResponseCode(code: 500, message: __('validation_messages.common.update_failed', ['attribute' => 'Notification']), error: $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $res = $this->notificationService->delete($id);
            return $this->getResponseCode(code: 200, message: __('validation_messages.common.delete_success', ['attribute' => 'Notification']));
        } catch (Exception $e) {
            return $this->getResponseCode(code: 500, message: __('validation_messages.common.delete_failed', ['attribute' => 'Notification']), error: $e->getMessage());
        }
    }
}
