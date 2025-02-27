<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <input type="email" id="{{ $id }}" name="{{ $name }}" value="{{ old($name, $value) }}"
        class="form-control @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
