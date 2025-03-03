<x:admin.table-filter>
    <div class="col-md-6">
        <div class="field">
            <label for="category_id">Category</label>
            <select class="js-select2" name="category_id">
                <option value="">All</option>
                {{-- @foreach($categories as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach --}}
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="field">
            <label for="status">Status</label>
            <select class="js-select2" name="status">
                <option value="">All</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
    </div>
</x:admin.table-filter>
