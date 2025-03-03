<?php

namespace App\Services\Merchant;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\Brand;
class BrandService
{
    /**
     * Stores a new brand
     *
     * @param array $data The validated data of the brand
     *
     * @return bool
     *
     * @throws Exception
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            if (isset($data['logo'])) {
                $data['logo'] = Storage::disk(config('filesystems.default'))->put('logos', $data['logo']);
            }
            Brand::create($data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get all brands.
     *
     * @param int $per_page The number of brands to show per page
     * @param string $search The search query
     * @param string $order_by The column to order by
     * @param string $order The order direction (asc/desc)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of brands
     */
    public function index($request)
    {
        $per_page = $request->input('per_page', 20);
        $search = $request->input('search');
        $order_by = $request->input('order_by', 'id');
        $order = $request->input('order', 'desc');
        $status = $request->input('status', '');
        $query = Brand::select(['id', 'name', 'category_id', 'logo', 'website_url', 'status'])
            ->with('category')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
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
     * Retrieve all brands as a collection of id => name.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public function allBrands()
    {
        return Brand::orderBy('name')->get();
    }

    /**
     * Update the specified brand in the database.
     *
     * @param int $id The ID of the brand to update.
     * @param array $data The data to update the brand with.
     * @throws Exception If an error occurs during the update process.
     */
    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::findOrfail($id);
            if (isset($data['logo'])) {
                Storage::disk(config('filesystems.default'))->delete($brand->logo);
                $data['logo'] = $data['logo']->store('logos', 'public');
            }
            $brand->update($data);
            DB::commit();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Retrieve a brand by its ID.
     *
     * @param int $id The ID of the brand to retrieve.
     * @return \App\Models\Brand The brand model instance.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no brand is found.
     */
    public function getBrand($id)
    {
        return Brand::findOrfail($id);
    }

    /**
     * Delete a brand by its ID.
     *
     * @param int $id The ID of the brand to delete.
     * @return bool True if the brand was successfully deleted, false otherwise.
     * @throws Exception If an error occurs during the deletion process.
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::findOrfail($id);
            Storage::disk('public')->delete($brand->logo);
            $brand->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Toggles the status of a brand.
     *
     * @param int $brandId The ID of the brand to toggle the status of.
     *
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no brand is found.
     */
    public function changeStatus($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        $brand->status = $brand->status === '1' ? '0' : '1';
        $brand->save();
    }
}
