<div class="mb-3">
    <x-forms.label :for="$id" :text="$label" :required="$required" />

    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control ckeditor">
        {{ old($name, $value) }}
    </textarea>
</div>
