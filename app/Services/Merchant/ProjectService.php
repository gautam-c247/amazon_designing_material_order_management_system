<?php

namespace App\Services\Merchant;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;

class ProjectService
{
    /**
     * Stores a new project
     *
     * @param array $data The validated data of the project
     *
     * @return bool
     *
     * @throws Exception
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $data['user_id'] = Auth::id();
            $services = $data['service_id'];

            unset($data['brand_id']);
            unset($data['service_id']);

            $project = Project::create($data);
            $project->service()->attach($services);
            if ($data['images']) {
                $images = $data['images'];
                unset($data['images']);
                foreach ($images as $image) {
                    $path = Storage::disk(config('filesystems.default'))->put('projects', $image);
                    $project->media()->create(['name' => $path]);
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
     * Get all projects.
     *
     * @param int $per_page The number of projects to show per page
     * @param string $search The search query
     * @param string $order_by The column to order by
     * @param string $order The order direction (asc/desc)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of projects
     */
    public function index($request)
    {
        $per_page = $request->input('per_page', 20);
        $search = $request->input('search');
        $order_by = $request->input('order_by', 'id');
        $order = $request->input('order', 'desc');
        $status = $request->input('status', '');
        $user_id = $request->input('user', '');
        $query = Project::select(['id', 'name', 'user_id', 'product_id', 'guidelines', 'notes', 'priority', 'status'])
            ->with('user')
            ->with('product.brand')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('product.brand', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        if ($status != '') {
            $query->where('status', $status);
        }
        if($user_id != ''){
            $query->where('user_id', $user_id);
        }
        $query->orderBy($order_by, $order);

        return $query->paginate($per_page);
    }

    /**
     * Retrieve all projects as a collection of id => name.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public function allProjects()
    {
        return Project::orderBy('name')->get();
    }

    /**
     * Update the specified project in the database.
     *
     * @param int $id The ID of the project to update.
     * @param array $data The data to update the project with.
     * @throws Exception If an error occurs during the update process.
     */
    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $project = Project::findOrFail($id);
            $services = $data['service_id'];

            unset($data['brand_id']);
            unset($data['service_id']);

            $project->update($data);
            $project->service()->sync($services);
            if (isset($data['images'])) {
                $images = $data['images'];
                unset($data['images']);
                foreach ($images as $image) {
                    $path = Storage::disk(config('filesystems.default'))->put('projects', $image);
                    $project->media()->create(['name' => $path]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Retrieve a project by its ID.
     *
     * @param int $id The ID of the project to retrieve.
     * @return \App\Models\Project The project model instance.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no project is found.
     */
    public function getProject($id)
    {
        return Project::findOrfail($id);
    }

    /**
     * Delete a project by its ID.
     *
     * @param int $id The ID of the project to delete.
     * @return bool True if the project was successfully deleted, false otherwise.
     * @throws Exception If an error occurs during the deletion process.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $project = Project::findOrFail($id);
            $project->service()->detach();
            foreach ($project->media as $media) {
                Storage::disk(config('filesystems.default'))->delete($media->name);
                $media->delete();
            }
            $project->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Toggles the status of a project.
     *
     * @param int $projectId The ID of the project to toggle the status of.
     *
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no project is found.
     */
    public function changeStatus($projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->status = $project->status === 'Completed' ? 'Pending' : 'Completed';
        $project->save();
    }

    /**
     * Retrieve a collection of all users as name => id pairs.
     *
     * @return \Illuminate\Support\Collection<string, int>
     */

    public function getAllUsers(){
        return User::pluck('name', 'id');
    }
    /**
     * Retrieve a collection of all brands as name => id pairs, that belong to the currently
     * authenticated user.
     *
     * @return \Illuminate\Support\Collection<string, int>
     */
    public function getAllBrands(){
        return Brand::where('user_id', auth()->user()->id)->pluck('name', 'id');
    }
/**
 * Fetch products by brand ID.
 *
 * @param \Illuminate\Http\Request $request The request containing the brand ID.
 * @return \Illuminate\Support\Collection<string, int> A collection of product names and their IDs.
 */

    public function fetchProducts($request)
    {
        return Product::where('brand_id', $request->brand_id)->pluck('name', 'id');
    }
/**
 * Retrieve a collection of all services as name => id pairs.
 *
 * @return \Illuminate\Support\Collection<string, int>
 */

    public function getServices(){
        return Service::pluck('name', 'id');
    }
}
