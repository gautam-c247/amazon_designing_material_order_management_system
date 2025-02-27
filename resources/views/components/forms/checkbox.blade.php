<div class="mb-3 form-check">
    <x-forms.label :for="$id" :text="$label" />

    <input type="checkbox" id="{{ $id }}" name="{{ $name }}" class="form-check-input"
        value="{{ $value }}" @if ($checked) checked @endif
        @if ($required) required @endif>

</div>
