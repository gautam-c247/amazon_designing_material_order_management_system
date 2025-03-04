@extends('admin.dashboard.layout')
@section('content')
    <main class="body-wrapper">
        <div class="page-wrapper">
            <!-- Page-Title -->
            <div class="pt-3 mb-3 row justify-content-between align-items-center gy-4">
                <div class="col-md-4 col-12">
                    <h1 class="m-0">Notifications</h1>
                </div>
                <div class="col-md-8 col-12">
                    <div class="flex-wrap gap-2 d-flex justify-content-start justify-content-md-end">
                        <!-- search-input -->
                        <div class="field flex-sm-100">
                            <x-admin.table-search placeholder="Search by Name, Email" />
                        </div>
                        @include('admin.user.filter')
                        <a href="{{ route('notification.create') }}" id="addUser"
                            class="notification-form-button btn btn-secondary with-icon">Create Notification
                            <span class="iconify" data-icon="mdi:plus-circle-outline" data-inline="false"></span></a>
                    </div>
                </div>
            </div>
            <!-- Inner-wrapper -->
            <x-admin.table>
                <x-slot:head>
                    <th>
                        <div class="heading">
                            <h6>Title</h6>
                            <x-admin.sort-icon order-by="title" order="asc" />
                        </div>
                    </th>
                    <th>
                        <div class="heading">
                            <h6>Message</h6>
                            <x-admin.sort-icon order-by="message" order="asc" />
                        </div>
                    </th>
                    <th>
                        Recipients
                        <x-admin.sort-icon order-by="recipients" order="asc" />
                    </th>
                    <th>
                        Delivery Status
                        <x-admin.sort-icon order-by="delivery_status" order="asc" />
                    </th>
                    <th>
                        Push time
                        <x-admin.sort-icon order-by="push_time" order="asc" />
                    </th>
                    <th>
                        Created At
                        <x-admin.sort-icon order-by="created_at" order="asc" />
                    </th>
                </x-slot:head>

            </x-admin.table>
        </div>
    </main>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/view-scripts/notifications.js') }}"></script>
    <script src="{{ asset('admin/assets/js/view-scripts/common.js') }}"></script>
@endsection
