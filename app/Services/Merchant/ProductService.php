<?php

namespace App\Services\Merchant;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Media;

class ProductService
{
    /**
     * Stores a new product
     *
     * @param array $data The validated data of the product
     * @param array $images The images to be uploaded
     *
     * @return bool
     *
     * @throws Exception
     */
    public function store($data, $images)
    {
        DB::beginTransaction();
        try {
            unset($data['images']);
            $data['user_id'] = auth()->id();
            $product = Product::create($data);
            if ($images) {
                foreach ($images as $image) {
                    $path = Storage::disk(config('filesystems.default'))->put('products', $image);
                    $product->media()->create(['name' => $path]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get all products.
     *
     * @param int $per_page The number of products to show per page
     * @param string $search The search query
     * @param string $order_by The column to order by
     * @param string $order The order direction (asc/desc)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of products
     */
    public function index($request)
    {
        $per_page = $request->input('per_page', 20);
        $search = $request->input('search');
        $order_by = $request->input('order_by', 'id');
        $order = $request->input('order', 'desc');
        $status = $request->input('status', '');
        $brand_id = $request->input('brand', '');
        $query = Product::select(['id', 'name', 'brand_id', 'description', 'service_status'])
            ->with('brand')
            ->with('media')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        if ($status != '') {
            $query->where('service_status', $status);
        }
        if($brand_id != ''){
            $query->where('brand_id', $brand_id);
        }
        $query->orderBy($order_by, $order);

        return $query->paginate($per_page);
    }

    /**
     * Retrieve all products as a collection of id => name.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public function allProducts()
    {
        return Product::orderBy('name')->get();
    }

    /**
     * Update the specified product in the database.
     *
     * @param int $id The ID of the product to update.
     * @param array $data The data to update the product with.
     * @param array $images The images to be uploaded
     * @throws Exception If an error occurs during the update process.
     */
    public function update($id, $data, $images)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->update($data);

            if ($images) {
                foreach ($images as $image) {
                    $path = Storage::disk('public')->put('products', $image);
                    $product->media()->create(['name' => $path]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Retrieve a product by its ID.
     *
     * @param int $id The ID of the product to retrieve.
     * @return \App\Models\Product The product model instance.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no product is found.
     */
    public function getProduct($id)
    {
        return Product::with('media')->findOrfail($id);
    }

    /**
     * Delete a product by its ID.
     *
     * @param int $id The ID of the product to delete.
     * @return bool True if the product was successfully deleted, false otherwise.
     * @throws Exception If an error occurs during the deletion process.
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrfail($id);
            Storage::disk('public')->delete($product->image);
            $product->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Toggles the status of a product.
     *
     * @param int $productId The ID of the product to toggle the status of.
     *
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no product is found.
     */
    public function changeStatus($productId)
    {
        $product = Product::findOrFail($productId);
        $product->service_status = $product->service_status === '1' ? '0' : '1';
        $product->save();
    }

    /**
     * Returns a collection of all brands as name => id pairs.
     *
     * @return \Illuminate\Support\Collection<string, int>
     */
    public function getAllBrands(){
        return Brand::pluck('name', 'id');
    }
    public function deleteImage($id)
    {
        $media = Media::findOrFail($id);
        Storage::disk(config('filesystems.default'))->delete($media->name);
        $media->delete();
    }
   

}
