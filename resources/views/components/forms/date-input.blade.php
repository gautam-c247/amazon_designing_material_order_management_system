<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <input type="date" id="{{ $id }}" name="{{ $name }}" value="{{ old($name, $value) }}"
        class="form-control @error($name) is-invalid @enderror" {{ $required ? 'required' : '' }}
        {{ $min !== null ? "min=$min" : '' }} {{ $max !== null ? "max=$max" : '' }}>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
