<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <select id="{{ $id }}" name="{{ $name }}{{ $multiple ? '[]' : '' }}" class="form-control select2"
        {{ $multiple ? 'multiple' : '' }} data-placeholder="{{ $placeholder }}">

        <option></option> <!-- Placeholder -->
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" {{ in_array($value, (array) $selected) ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>
