<?php

namespace App\Services\Admin;

use App\Jobs\CreateNotificationJob;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Stores a new notification
     *
     * @param array $data The validated data of the notification
     *
     * @return bool
     *
     * @throws Exception
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $data['recipients'] = json_encode($data['recipients']);
            $notification = Notification::create($data);
            $jobId = $this->createJob(time: $data['push_time'], notificationId: $notification->id);

            $notification->update(['job_id' => $jobId]); // Store the job ID in the notification
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get all notifications.
     *
     * @param int $per_page The number of notifications to show per page
     * @param string $search The search query
     * @param string $order_by The column to order by
     * @param string $order The order direction (asc/desc)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of notifications
     */
    public function index($request)
    {
        $per_page = $request->input('per_page', 20);
        $search = $request->input('search');
        $order_by = $request->input('order_by', 'id');
        $order = $request->input('order', 'desc');
        $status = $request->input('status', '');
        $query = Notification::select(['id', 'title', 'message', 'recipients', 'delivery_status', 'push_time', 'created_at'])
            ->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        if ($status != '') {
            $query->where('status', $status);
        }
        $query->orderBy($order_by, $order);

        return $query->paginate($per_page);
    }

    /**
     * Retrieve all notifications as a collection of id => title.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public function allNotifications()
    {
        return Notification::orderBy('title')->get();
    }

    public function create()
    {
        $users = User::pluck('name', 'id')->toArray(); // Convert to array
        $users += ['designers' => 'Designers', 'merchants' => 'Merchants']; // Merge associative keys
        return $users;
    }

    /**
     * Update the specified notification in the database.
     *
     * @param int $id The ID of the notification to update.
     * @param array $data The data to update the notification with.
     * @throws Exception If an error occurs during the update process.
     */
    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $notification = Notification::findOrfail($id);
            $notification->update($data);
            $jobId = $this->createJob(time: $data['push_time'], notificationId: $notification->id,jobId: $notification->job_id);
            $notification->update(['job_id' => $jobId]); // Store the job ID in the notification
            DB::commit();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Retrieve a notification by its ID.
     *
     * @param int $id The ID of the notification to retrieve.
     * @return \App\Models\Notification The notification model instance.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no notification is found.
     */
    public function getNotification($id)
    {
        return Notification::findOrfail($id);
    }

    /**
     * Delete a notification by its ID.
     *
     * @param int $id The ID of the notification to delete.
     * @return bool True if the notification was successfully deleted, false otherwise.
     * @throws Exception If an error occurs during the deletion process.
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $notification = Notification::findOrfail($id);
            $notification->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Create a job for the notification.
     *
     * @param string $time The time to push the notification.
     * @param int $notificationId The ID of the notification.
     * @return string The job ID.
     */
    private function createJob($time, $notificationId, $jobId = null)
    {
        if ($jobId) {
            Bus::delete($jobId);
        }
        $job = new CreateNotificationJob($notificationId); // Create job instance
        return Bus::dispatch($job); // Dispatch and get Job ID
    }
}
