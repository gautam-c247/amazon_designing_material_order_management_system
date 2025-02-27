<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    /**
     * Stores a new category
     *
     * @param array $data The validated data of the category
     *
     * @return bool
     *
     * @throws Exception
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            Category::create($data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }


    /**
     * Get all categories with their parent's name.
     *
     * @param int $per_page The number of categories to show per page
     * @param string $search The search query
     * @param string $order_by The column to order by
     * @param string $order The order direction (asc/desc)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of categories
     */
    public function index($per_page, $search, $order_by, $order, $status)
    {
        $query = Category::with(['parent' => function ($q) {
            $q->select('id', 'name', 'created_at'); // Only select necessary columns
        }])
            ->select(['id', 'name', 'parent_id', 'status', 'created_at'])
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%') // Search in the current category name
                    ->orWhereHas('parent', function ($q) use ($search) { // Search in the parent category name
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        if ($status != '') {
            $query->where('status', $status);
        }
        $query->orderBy($order_by, $order);

        return $query->paginate($per_page);
    }
    /**
     * Retrieve all categories as a collection of id => name.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public function allCategories()
    {
        $categories = Category::orderBy('name')->get();
        return $this->CategoryHierarchy($categories);
    }

    private function CategoryHierarchy($categories, $parentId = null, $depth = 0)
    {
        $data = [];
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $data[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'children' => $this->CategoryHierarchy($categories, $category->id, $depth + 1)
                ];
            }
        }
        return $data;
    }

    /**
     * Update the specified category in the database.
     *
     * @param int $id The ID of the category to update.
     * @param array $data The data to update the category with.
     * @throws Exception If an error occurs during the update process.
     */

    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $category = Category::findOrfail($id);
            $category->update($data);
            DB::commit();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Retrieve a category by its ID.
     *
     * @param int $id The ID of the category to retrieve.
     * @return \App\Models\Category The category model instance.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no category is found.
     */

    public function getCategory($id)
    {
        return Category::findOrfail($id);
    }

    /**
     * Delete a category by its ID.
     *
     * @param int $id The ID of the category to delete.
     * @return bool True if the category was successfully deleted, false otherwise.
     * @throws Exception If an error occurs during the deletion process.
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $category = Category::findOrfail($id);
            $category->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * Toggles the status of a category.
     *
     * @param int $userId The ID of the category to toggle the status of.
     *
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no category is found.
     */
    public function changeStatus($userId)
    {
        $user = Category::findOrFail($userId);
        $user->status = $user->status == 1 ? '0' : '1';
        $user->save();
    }
}
