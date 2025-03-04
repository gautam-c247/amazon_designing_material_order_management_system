<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\ProductRequest;
use App\Services\Merchant\ProductService;
use App\Traits\ResponseCodeTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use ResponseCodeTrait;

    protected $productService;

    /**
     * ProductController constructor.
     *
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $products = $this->productService->index($request);
                return $this->getResponseCode(200, null, $products, __('validation_messages.common.fetch_success', ['attribute' => 'Products']));
            } catch (Exception $e) {
                return $this->getResponseCode(400, null, null, __('validation_messages.common.fetch_failed', ['attribute' => 'Products']), $e->getMessage());
            }
        } else {
            $brands = $this->productService->getAllBrands();
            return view('merchant.product.index', compact('brands'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = $this->productService->getAllBrands();
        return view('merchant.product.create', compact('brands'))->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        try {
            $this->productService->store($data, $request->file('images'));
            return $this->getResponseCode(201, null, null, __('validation_messages.common.create_success', ['attribute' => 'Product']));
        } catch (Exception $e) {
            Log::error('Failed to create product: ' . $e->getMessage());
            return $this->getResponseCode(400, null, null, __('validation_messages.common.create_failed', ['attribute' => 'Product']), $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->getProduct($id);
        return view('merchant.product.show', compact('product'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brands = $this->productService->getAllBrands();
        $product = $this->productService->getProduct($id);
        return view('merchant.product.create', compact('brands', 'product'))->render();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $this->productService->update($id, $data, $request->file('images'));
            return $this->getResponseCode(200, null, null, __('validation_messages.common.update_success', ['attribute' => 'Product']));
        } catch (Exception $e) {
            Log::error('Failed to create product: ' . $e->getMessage());

            return $this->getResponseCode(400, null, null, __('validation_messages.common.update_failed', ['attribute' => 'Product']), $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->productService->delete($id);
            return $this->getResponseCode(200, null, null, __('validation_messages.common.delete_success', ['attribute' => 'Product']));
        } catch (Exception $e) {
            return $this->getResponseCode(400, null, null, __('validation_messages.common.delete_failed', ['attribute' => 'Product']), $e->getMessage());
        }
    }

    /**
     * Changes the status of a product.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, string $id)
    {
        try {
            $this->productService->changeStatus($id);
            return $this->getResponseCode(200, null, null, __('validation_messages.common.status_change_success'));
        } catch (Exception $e) {
            return $this->getResponseCode(400, null, null, __('validation_messages.common.status_change_failed'), $e->getMessage());
        }
    }
    public function deleteImage(Request $request, string $id)
    {
        try {
            $this->productService->deleteImage($id);
            return $this->getResponseCode(200, null, null, __('validation_messages.common.image_delete_success'));
        } catch (Exception $e) {
            return $this->getResponseCode(400, null, null, __('validation_messages.common.image_delete_failed'), $e->getMessage());
        }
    }
}
