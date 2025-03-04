<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />
    <div class="upload-file">
        <input type="file" id="{{ $id }}" multiple="{{ $multiple }}" name="{{ $name }}" class="custom-file-input"
            @if ($required) required @endif accept="{{ $accept }}">
    </div>
</div>
