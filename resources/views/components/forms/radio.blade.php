<div class="form-check">
    <x-forms.label :for="$id" :text="$label" />

    <input type="radio" id="{{ $id }}" name="{{ $name }}" class="form-check-input"
        value="{{ $value }}" @if ($checked) checked @endif
        @if ($required) required @endif>
</div>
