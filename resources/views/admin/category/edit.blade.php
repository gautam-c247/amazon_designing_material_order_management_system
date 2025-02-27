@extends('admin.dashboard.layout')
@section('content')
    <main class="body-wrapper">
        <x-admin.breadcrumb :items="[
            ['label' => 'Category', 'url' => route('category.index'), 'active' => false],
            ['label' => 'List', 'url' => route('category.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ]" />
        <div class="page-wrapper">
            <div class="row justify-content-between align-items-center mb-3">
                <div class="col-12 col-sm-auto">
                    <h1 class="m-0">Category</h1>
                </div>
            </div>
            <div class="inner-wrapper">
                <h2 class="m-0">Edit Category</h2>
                <form id="editCategoryForm" method="post" action="{{ route('category.update', $category->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="input-wrapper">
                        <div class="row gy-3">
                            <!-- Category Name -->
                            <div class="col-md-6">
                                <div class="field">
                                    <label for="name">Category Name : <sup>*</sup></label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name', $category->name) }}" />
                                    @error('name')
                                        <span class="error-message text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Parent Category -->
                            <div class="col-md-6">
                                <div class="field">
                                    <label for="parent_cat">Parent Category :</label>
                                    <select id="parent_cat" name="parent_id" class="js-select2">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $key => $parentCategory)
                                            <option value="{{ $key }}"
                                                {{ old('parent_id', $category->parent_id) == $key ? 'selected' : '' }}>
                                                {{ $parentCategory }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <span class="error-message text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-secondary mt-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('admin/assets/js/view-scripts/category-management/edit.js') }}"></script>
@endsection
