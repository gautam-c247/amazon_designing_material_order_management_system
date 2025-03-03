<x:admin.form-modal title="{{ isset($brand) ? 'Edit Brand' : 'Create Brand' }}"
    form-action="{{ isset($brand) ? route('merchant.brand.update', $brand->id) : route('merchant.brand.store') }}"
    method="{{ isset($brand) ? 'PUT' : 'POST' }}">
    <!-- Name -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.text-input id="name" name="name" label="Name" value="{{ $brand->name ?? old('name') }}" :required="true" minlength="3" />
        </div>
    </div>
    <!-- Category -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.select2 id="category_id" :options="$categories" name="category_id" label="Category" selected="{{ $brand->category_id ?? old('category_id') }}" :required="true" />
        </div>
    </div>
    <!-- Logo -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.file id="logo" name="logo" label="Logo" :required="!isset($brand)" />
        </div>
    </div>
    <!-- Website URL -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.url id="website_url" name="website_url" label="Website URL" value="{{ $brand->website_url ?? old('website_url') }}" />
        </div>
    </div>
    <!-- About -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.textarea id="about" name="about" label="About" value="{{ $brand->about ?? old('about') }}" />
        </div>
    </div>
    <!-- Pronunciation -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.text-input id="pronunciation" name="pronunciation" label="Pronunciation" value="{{ $brand->pronunciation ?? old('pronunciation') }}" />
        </div>
    </div>
    <!-- Instagram URL -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.url id="instagram_url" name="instagram_url" label="Instagram URL" value="{{ $brand->instagram_url ?? old('instagram_url') }}" />
        </div>
    </div>
</x:admin.form-modal>

