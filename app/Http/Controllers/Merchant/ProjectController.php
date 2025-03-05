<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\ProjectRequest;
use App\Services\Merchant\ProjectService;
use App\Traits\ResponseCodeTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    use ResponseCodeTrait;

    protected $projectService;

    /**
     * ProjectController constructor.
     *
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $projects = $this->projectService->index($request);
                return $this->getResponseCode(200, null, $projects, __('validation_messages.common.fetch_success', ['attribute' => 'Projects']));
            } catch (Exception $e) {
                return $this->getResponseCode(400, null, null, __('validation_messages.common.fetch_failed', ['attribute' => 'Projects']), $e->getMessage());
            }
        } else {
            $users = $this->projectService->getAllUsers();
            return view('merchant.project.index', compact('users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = $this->projectService->getAllBrands();
        $services =$this->projectService->getServices();
        return view('merchant.project.create', compact('brands', 'services'))->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        try {
            $this->projectService->store($data);
            return $this->getResponseCode(201, null, null, __('validation_messages.common.create_success', ['attribute' => 'Project']));
        } catch (Exception $e) {
            Log::error('Failed to create project: ' . $e->getMessage());
            return $this->getResponseCode(400, null, null, __('validation_messages.common.create_failed', ['attribute' => 'Project']), $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = $this->projectService->getProject($id);
        return view('merchant.project.show', compact('project'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $project = $this->projectService->getProject($id);
        $brands = $this->projectService->getAllBrands();
        $services =$this->projectService->getServices();
        return view('merchant.project.create', compact('project','brands', 'services'))->render();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $this->projectService->update($id, $data);
            return $this->getResponseCode(200, null, null, __('validation_messages.common.update_success', ['attribute' => 'Project']));
        } catch (Exception $e) {
            Log::error('Failed to update project: ' . $e->getMessage());
            return $this->getResponseCode(400, null, null, __('validation_messages.common.update_failed', ['attribute' => 'Project']), $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->projectService->destroy($id);
            return $this->getResponseCode(200, null, null, __('validation_messages.common.delete_success', ['attribute' => 'Project']));
        } catch (Exception $e) {
            Log::error('Failed to delete project: ' . $e->getMessage());
            return $this->getResponseCode(400, null, null, __('validation_messages.common.delete_failed', ['attribute' => 'Project']), $e->getMessage());
        }
    }

    /**
     * Changes the status of a project.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, string $id)
    {
        try {
            $this->projectService->changeStatus($id);
            return $this->getResponseCode(200, null, null, __('validation_messages.common.status_change_success'));
        } catch (Exception $e) {
            return $this->getResponseCode(400, null, null, __('validation_messages.common.status_change_failed'), $e->getMessage());
        }
    }
    public function fetchProducts(Request $request)
    {
        $products = $this->projectService->fetchProducts($request);
        return $this->getResponseCode(200, null, $products, __('validation_messages.common.fetch_success', ['attribute' => 'Products']));
    }

}
