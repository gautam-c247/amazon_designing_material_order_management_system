<x:admin.form-modal title="{{ isset($selectedCategory) ? 'Edit Category' : 'Create Category' }}"
    form-action="{{ isset($selectedCategory) ? route('category.update', $selectedCategory->id) : route('category.store') }}"
    method="{{ isset($selectedCategory) ? 'PUT' : 'POST' }}">
    <!-- Category Name -->
    <div class="col-md-12">
        <div class="field">
            <x-forms.label for="name" text="Category Title " :required="true" />
            <input type="text" id="name" name="name" class="form-control"
                value="{{ $selectedCategory->name ?? old('name') }}" />
            @error('name')
                <span class="error-message text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <!-- Parent Category -->

    <div class="field">
        <x-forms.label for="parent_id" text="Parent Category " :required="false" />
        <select class="js-select2" id="parent_cat" name="parent_id">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                @include('admin.category.select-box', [
                    'category' => $category,
                    'depth' => 0,
                    'selectedCategory' => $selectedCategory ?? null,
                ])
            @endforeach
        </select>
        @error('parent_id')
            <span class="error-message text-danger">{{ $message }}</span>
        @enderror
    </div>

</x:admin.form-modal>
