<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <input type="file" id="{{ $id }}" name="{{ $name }}" class="form-control"
        @if ($required) required @endif accept="{{ $accept }}">
</div>
