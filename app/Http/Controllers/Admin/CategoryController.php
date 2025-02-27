<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\ResponseCodeTrait;
use App\Services\Admin\Category\CategoryService;
use App\Http\Requests\Admin\Category\{CreateCategoryRequest, UpdateCategoryRequest};

class CategoryController extends Controller
{
    use ResponseCodeTrait;
    protected $categoryService;

    /**
     * CategoryController constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     *
     * This method handles the retrieval of categories. It supports both JSON and non-JSON requests.
     * For JSON requests, it fetches categories based on pagination, search, order, and status filters.
     * It returns a JSON response with the list of categories and a success message.
     * For non-JSON requests, it returns the categories view with a title.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $per_page = $request->input('per_page', 20);
            $search = $request->input('search');
            $order_by = $request->input('order_by', 'id');
            $order = $request->input('order', 'desc');
            $status = $request->input('status', '');
            $categories = $this->categoryService->index($per_page, $search, $order_by, $order, $status);
            return $this->getResponseCode(code: 200, data: $categories, message: __('categories.fetch_success', ['attribute' => 'Categories']));
        } else {
            $title = 'Categories';
            return view('admin.category.index', compact('title'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->allCategories();
        return view('admin.category.create', compact('categories'));
    }

    public function store(CreateCategoryRequest $request)
    {
        $data = $request->validated();
        if ($request->expectsJson()) {
            try {
                $res = $this->categoryService->store($data);
                return $this->getResponseCode(code: 201, message: __('categories.create_success', ['attribute' => 'Category']));
            } catch (Exception $e) {
                return $this->getResponseCode(code: 500, message: __('categories.create_failed', ['attribute' => 'Category']), error: $e->getMessage());
            }
        } else {
            try {
                $res = $this->categoryService->store($data);
                return redirect()->route('category.index')->with('success', __('categories.create_success', ['attribute' => 'Category']));
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage())->withInput();
            }
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
                $category = $this->categoryService->getCategory($id);
                return $this->getResponseCode(code: 200, data: $category, message: __('categories.fetch_success', ['attribute' => 'Categories']));
            } catch (Exception $e) {
                return $this->getResponseCode(code: 500, message: $e->getMessage(), error: $e->getMessage());
            }
        } else {
            try {
                $selectedCategory = $this->categoryService->getCategory($id);
                $categories = $this->categoryService->allCategories();
                return view('admin.category.create', compact('selectedCategory', 'categories'));
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage())->withInput();
            }
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $data = $request->validated();
        if ($request->expectsJson()) {
            try {
                $res = $this->categoryService->update($id, $data);
                return $this->getResponseCode(code: 201, message: __('categories.update_success', ['attribute' => 'Category']));
            } catch (Exception $e) {
                return $this->getResponseCode(code: 500, message: __('categories.update_failed', ['attribute' => 'Category']), error: $e->getMessage());
            }
        } else {
            try {
                $res = $this->categoryService->update($id, $data);
                return redirect()->route('category.index')->with('success', __('categories.update_success', ['attribute' => 'Category']));
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage())->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $res = $this->categoryService->delete($id);
            return $this->getResponseCode(code: 200, message: __('categories.delete_success', ['attribute' => 'Category']));
        } catch (Exception $e) {
            return $this->getResponseCode(code: 500, message: __('categories.delete_failed', ['attribute' => 'Category']), error: $e->getMessage());
        }
    }

    /**
     * Changes the status of a category.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, string $id)
    {
        try {
            $res = $this->categoryService->changeStatus($id);
            return $this->getResponseCode(code: 200, message: __('categories.status_change_success'));
        } catch (Exception $e) {
            return $this->getResponseCode(500, message: __('categories.status_change_failed'), error: $e->getMessage());
        }
    }
}
