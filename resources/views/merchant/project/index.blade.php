@extends('user.dashboard.common.layout', ['title' => 'Projects'])
@section('content')
    <main class="body-wrapper">
        <div class="page-wrapper">
            <!-- Page-Title -->
            <div class="pt-3 mb-3 row justify-content-between align-items-center gy-4">
                <div class="col-md-4 col-12">
                    <h1 class="m-0">Projects</h1>
                </div>
                <div class="col-md-8 col-12">
                    <div class="flex-wrap gap-2 d-flex justify-content-start justify-content-md-end">
                        <!-- search-input -->
                        <div class="field flex-sm-100">
                            <x-admin.table-search placeholder="Search by Name, Merchant" />
                        </div>
                        @include('merchant.project.filter')
                        <a href="{{ route('merchant.project.create') }}" class="cat-from-button btn btn-secondary with-icon">Create
                            Project <span class="iconify" data-icon="mdi:plus-circle-outline"
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
                            <h6>Merchant</h6>
                            <x-admin.sort-icon order-by="user_id" order="asc" />
                        </div>
                    </th>
                    <th>
                        <div class="heading">
                            <h6>Brand</h6>
                            <x-admin.sort-icon order-by="brand_id" order="asc" />
                        </div>
                    </th>
                    <th>
                        <div class="heading">
                            <h6>Product</h6>
                            <x-admin.sort-icon order-by="product_id" order="asc" />
                        </div>
                    </th>
                    <th>
                        Guidelines
                        <x-admin.sort-icon order-by="guidelines" order="asc" />
                    </th>
                    <th>
                        Notes
                        <x-admin.sort-icon order-by="notes" order="asc" />
                    </th>
                    <th>
                        Priority
                        <x-admin.sort-icon order-by="priority" order="asc" />
                    </th>
                    <th>
                        Status
                        <x-admin.sort-icon order-by="status" order="asc" />
                    </th>
                </x-slot:head>
                <!-- Table body will be populated by JavaScript -->
            </x-admin.table>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
    const projectsValidation = @json(__('merchant'));
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="{{ asset('user/projects.js') }}"></script>
    <script src="{{ asset('admin/assets/js/view-scripts/common.js') }}"></script>
@endsection
