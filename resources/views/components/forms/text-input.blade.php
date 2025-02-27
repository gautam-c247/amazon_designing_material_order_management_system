<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <input type="text" id="{{ $id }}" name="{{ $name }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" class="form-control @error($name) is-invalid @enderror"
        {{ $required ? 'required' : '' }}>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
