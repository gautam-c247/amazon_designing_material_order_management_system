<x:admin.table-filter>
    <div class="col-md-6">
        <div class="field">
            <label for="brand">Brand</label>
            <select class="js-select2" name="brand">
                <option value="">All</option>
                @foreach($brands as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="field">
            <label for="status">Status</label>
            <select class="js-select2" name="status">
                <option value="">All</option>
                <option value="1">Completed</option>
                <option value="0">Pending</option>
            </select>
        </div>
    </div>
</x:admin.table-filter>
