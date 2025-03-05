<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <input type="password" id="{{ $id }}" name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}>
        <span class="password-toggle-icon"><span class="iconify" id="eye-icon"
            data-icon="mdi:eye-off" data-inline="false"></span></span>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
