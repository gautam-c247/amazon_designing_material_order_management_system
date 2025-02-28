@extends('admin.dashboard.layout')
@section('content')
    <main class="body-wrapper">
        <div class="page-wrapper">
            <!-- Page-Title -->
            <div class="pt-3 mb-3 row justify-content-between align-items-center gy-4">
                <div class="col-md-4 col-12">
                    <h1 class="m-0">Services</h1>
                </div>
                <div class="col-md-8 col-12">
                    <div class="flex-wrap gap-2 d-flex justify-content-start justify-content-md-end">
                        <!-- search-input -->
                        <div class="field flex-sm-100">
                            <x-admin.table-search placeholder="Search by Name, Description" />
                        </div>
                        @include('admin.service.filter')
                        <a href="{{ route('service.create') }}" class="cat-from-button btn btn-secondary with-icon">Create
                            Service <span class="iconify" data-icon="mdi:plus-circle-outline"
                                data-inline="false"></span></a>
                    </div>
                </div>
            </div>
            <!-- Inner-wrapper -->
            <x-admin.table>
                <x-slot:head>
                    <th>
                        <div class="heading">
                            <h6>Name</h6>
                            <x-admin.sort-icon order-by="name" order="asc" />
                        </div>
                    </th>
                    <th>
                        <div class="heading">
                            <h6>Description</h6>
                            <x-admin.sort-icon order-by="description" order="asc" />
                        </div>
                    </th>
                    <th>
                        Credit
                        <x-admin.sort-icon order-by="credit" order="asc" />
                    </th>
                    <th>
                        Status
                        <x-admin.sort-icon order-by="status" order="asc" />
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
    <script src="{{ asset('admin/assets/js/view-scripts/services.js') }}"></script>
    <script src="{{ asset('admin/assets/js/view-scripts/common.js') }}"></script>
@endsection
