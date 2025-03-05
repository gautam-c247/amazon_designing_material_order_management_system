<?php

namespace App\Services\Admin;

use App\Models\Service;
use Exception;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    /**
     * Stores a new service
     *
     * @param array $data The validated data of the service
     *
     * @return bool
     *
     * @throws Exception
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            Service::create($data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get all services.
     *
     * @param int $per_page The number of services to show per page
     * @param string $search The search query
     * @param string $order_by The column to order by
     * @param string $order The order direction (asc/desc)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of services
     */
    public function index($request)
    {
        $per_page = $request->input('per_page', 20);
        $search = $request->input('search');
        $order_by = $request->input('order_by', 'id');
        $order = $request->input('order', 'desc');
        $status = $request->input('status', '');
        $query = Service::select(['id', 'name', 'description', 'credit', 'status', 'created_at'])
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        if ($status != '') {
            $query->where('status', $status);
        }
        $query->orderBy($order_by, $order);

        return $query->paginate($per_page);
    }

    /**
     * Retrieve all services as a collection of id => name.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public function allServices()
    {
        return Service::orderBy('name')->get();
    }

    /**
     * Update the specified service in the database.
     *
     * @param int $id The ID of the service to update.
     * @param array $data The data to update the service with.
     * @throws Exception If an error occurs during the update process.
     */
    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $service = Service::findOrfail($id);
            $service->update($data);
            DB::commit();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Retrieve a service by its ID.
     *
     * @param int $id The ID of the service to retrieve.
     * @return \App\Models\Service The service model instance.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no service is found.
     */
    public function getService($id)
    {
        return Service::findOrfail($id);
    }

    /**
     * Delete a service by its ID.
     *
     * @param int $id The ID of the service to delete.
     * @return bool True if the service was successfully deleted, false otherwise.
     * @throws Exception If an error occurs during the deletion process.
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $service = Service::findOrfail($id);
            $service->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Toggles the status of a service.
     *
     * @param int $userId The ID of the service to toggle the status of.
     *
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no service is found.
     */
    public function changeStatus($userId)
    {
        $user = Service::findOrFail($userId);
        $user->status = $user->status == 1 ? '0' : '1';
        $user->save();
    }
}
