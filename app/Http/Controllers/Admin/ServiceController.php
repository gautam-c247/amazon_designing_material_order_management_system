<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\ResponseCodeTrait;
use App\Services\Admin\ServiceService;
use App\Http\Requests\Admin\ServiceRequest;

class ServiceController extends Controller
{
    use ResponseCodeTrait;
    protected $serviceService;

    /**
     * ServiceController constructor.
     *
     * @param ServiceService $serviceService
     */
    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Handles the retrieval of services.
     *
     * @param Request $request The input HTTP request object.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     *
     * This method handles the retrieval of services. It supports both JSON and non-JSON requests.
     * For JSON requests, it fetches services based on pagination, search, order, and status filters.
     * It returns a JSON response with the list of services and a success message.
     * For non-JSON requests, it returns the services view with a title.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $service = $this->serviceService->index($request);
            return $this->getResponseCode(code: 200, data: $service, message: __('validation_messages.common.fetch_success', ['attribute' => 'Services']));
        } else {
            $title = 'Services';
            return view('admin.service.index', compact('title'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $service = $this->serviceService->allServices();
        return view('admin.service.create', compact('service'));
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validated();
        try {
            $res = $this->serviceService->store($data);
            return $this->getResponseCode(code: 201, message: __('validation_messages.common.create_success', ['attribute' => 'Service']));
        } catch (Exception $e) {
            return $this->getResponseCode(code: 500, message: __('validation_messages.common.create_failed', ['attribute' => 'Service']), error: $e->getMessage());
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
        if ($request->expectsJson()) {
            try {
                $service = $this->serviceService->getService($id);
                return $this->getResponseCode(code: 200, data: $service, message: __('validation_messages.common.fetch_success', ['attribute' => 'Services']));
            } catch (Exception $e) {
                return $this->getResponseCode(code: 500, message: $e->getMessage(), error: $e->getMessage());
            }
        } else {
            try {
                $selectedService = $this->serviceService->getService($id);
                $service = $this->serviceService->allServices();
                return view('admin.service.create', compact('selectedService', 'service'));
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage())->withInput();
            }
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        $data = $request->validated();
            try {
                $res = $this->serviceService->update($id, $data);
                return $this->getResponseCode(code: 201, message: __('validation_messages.common.update_success', ['attribute' => 'Service']));
            } catch (Exception $e) {
                return $this->getResponseCode(code: 500, message: __('validation_messages.common.update_failed', ['attribute' => 'Service']), error: $e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $res = $this->serviceService->delete($id);
            return $this->getResponseCode(code: 200, message: __('validation_messages.common.delete_success', ['attribute' => 'Service']));
        } catch (Exception $e) {
            return $this->getResponseCode(code: 500, message: __('validation_messages.common.delete_failed', ['attribute' => 'Service']), error: $e->getMessage());
        }
    }

    /**
     * Changes the status of a service.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, string $id)
    {
        try {
            $res = $this->serviceService->changeStatus($id);
            return $this->getResponseCode(code: 200, message: __('validation_messages.common.status_change_success'));
        } catch (Exception $e) {
            return $this->getResponseCode(500, message: __('validation_messages.common.status_change_failed'), error: $e->getMessage());
        }
    }
}
