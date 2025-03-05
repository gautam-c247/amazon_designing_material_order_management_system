<x:admin.table-filter>
    <div class="col-md-6">
        <div class="field">
            <label for="user_id">Merchant</label>
            <select class="js-select2" name="user_id">
                <option value="">All</option>
                @foreach($users as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="field">
            <label for="priority">Priority</label>
            <select class="js-select2" name="priority">
                <option value="">All</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
    </div>
</x:admin.table-filter>
