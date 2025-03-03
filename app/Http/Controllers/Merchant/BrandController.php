<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\BrandRequest;
use App\Models\Category;
use App\Services\Merchant\BrandService;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    protected $brandService;

    /**
     * BrandController constructor.
     *
     * @param BrandService $brandService
     */
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $brands = $this->brandService->index($request);
            return response()->json(['data' => $brands, 'message' => __('validation_messages.common.fetch_success', ['attribute' => 'Brands'])], 200);
        } else {
            $title = 'Brands';
            return view('merchant.brand.index', compact('title'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('merchant.brand.create', compact('categories'))->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $data = $request->validated();
        try {
            $this->brandService->store($data);
            return response()->json(['message' => __('validation_messages.common.create_success', ['attribute' => 'Brand'])], 201);
        } catch (Exception $e) {
            return response()->json(['message' => __('validation_messages.common.create_failed', ['attribute' => 'Brand']), 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('merchant.brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Brand $brand)
    {
        if ($request->expectsJson()) {
            try {
                $brand = $this->brandService->getBrand($brand->id);
                return response()->json(['data' => $brand, 'message' => __('validation_messages.common.fetch_success', ['attribute' => 'Brands'])], 200);
            } catch (Exception $e) {
                return response()->json(['message' => $e->getMessage(), 'error' => $e->getMessage()], 500);
            }
        } else {
            $categories = Category::pluck('name', 'id');
            return view('merchant.brand.create', compact('brand', 'categories'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        try {
            $this->brandService->update($brand->id, $data);
            return response()->json(['message' => __('validation_messages.common.update_success', ['attribute' => 'Brand'])], 201);
        } catch (Exception $e) {
            return response()->json(['message' => __('validation_messages.common.update_failed', ['attribute' => 'Brand']), 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        try {
            $this->brandService->delete($brand->id);
            return response()->json(['message' => __('validation_messages.common.delete_success', ['attribute' => 'Brand'])], 200);
        } catch (Exception $e) {
            return response()->json(['message' => __('validation_messages.common.delete_failed', ['attribute' => 'Brand']), 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Changes the status of a brand.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, string $id)
    {
        try {
            $this->brandService->changeStatus($id);
            return response()->json(['message' => __('validation_messages.common.status_change_success')], 200);
        } catch (Exception $e) {
            return response()->json(['message' => __('validation_messages.common.status_change_failed'), 'error' => $e->getMessage()], 500);
        }
    }
}
