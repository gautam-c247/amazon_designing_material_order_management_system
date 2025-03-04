@extends('admin.dashboard.layout', ['title' => 'Users'])
@section('content')
    <main class="body-wrapper">
        <div class="page-wrapper">
            <!-- Page-Title -->
            <div class="pt-3 mb-3 row justify-content-between align-items-center gy-4">
                <div class="col-md-4 col-12">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-md-8 col-12">
                    <div class="flex-wrap gap-2 d-flex justify-content-start justify-content-md-end">
                        <!-- search-input -->
                        <div class="field flex-sm-100">
                            <x-admin.table-search placeholder="Search by Name, Email" />
                        </div>
                        @include('admin.user.filter')
                        <a href="{{ route('users.create') }}" id="addUser"
                            class="user-form-button btn btn-secondary with-icon">Create User
                            <span class="iconify" data-icon="mdi:plus-circle-outline" data-inline="false"></span></a>
                    </div>
                </div>
            </div>
            <!-- Inner-wrapper -->
            <x-admin.table>
                <x-slot:head>
                    <th>
                        <div class="heading">
                            <h6>Name</h6>
                            <x:admin.sort-icon order="asc" orderBy="name" />
                        </div>
                    </th>
                    {{-- <th>
                        <div class="heading">
                            <h6>Phone Number</h6>
                            <x:admin.sort-icon order="asc" orderBy="contact_no" />
                        </div>
                    </th> --}}
                    <th>
                        <div class="heading">
                            <h6>Email</h6>
                            <x:admin.sort-icon order="asc" orderBy="email" />
                        </div>
                    </th>
                    {{-- <th>
                        <div class="heading">
                            <h6>Gender</h6>
                            <x:admin.sort-icon order="asc" orderBy="gender" />
                        </div>
                    </th> --}}
                    <th>
                        <div class="heading">
                            <h6>Role</h6>
                            <x:admin.sort-icon order="asc" orderBy="role" />
                        </div>
                    </th>
                    {{-- <th>
                        <div class="heading">
                            <h6>Date of birth</h6>
                            <x:admin.sort-icon order="asc" orderBy="date_of_birth" />
                        </div>
                    </th> --}}
                    <th>
                        <div class="heading">
                            <h6>Status</h6>
                            <x:admin.sort-icon order="asc" orderBy="status" />
                        </div>
                    </th>
                    <th>
                        <div class="heading">
                            <h6>Created At</h6>
                            <x:admin.sort-icon order="asc" orderBy="created_at" />
                        </div>
                    </th>
                </x-slot:head>
            </x-admin.table>
        </div>
    </main>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/view-scripts/common.js') }}"></script>
    <script src="{{ asset('admin/assets/js/view-scripts/users.js') }}"></script>
@endsection
