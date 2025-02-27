<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <input type="url" id="{{ $id }}" name="{{ $name }}" class="form-control"
        placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }}>
</div>
