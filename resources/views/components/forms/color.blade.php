<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <input type="color" id="{{ $id }}" name="{{ $name }}" class="form-control"
        value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }}>
</div>
