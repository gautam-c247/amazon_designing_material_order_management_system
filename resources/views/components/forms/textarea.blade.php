<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
        class="form-control @error($name) is-invalid @enderror" {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
