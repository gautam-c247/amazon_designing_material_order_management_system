<x:admin.form-modal title="{{ isset($product) ? 'Edit Product' : 'Create Product' }}"
    form-action="{{ isset($product) ? route('merchant.product.update', $product->id) : route('merchant.product.store') }}"
    method="{{ isset($product) ? 'PUT' : 'POST' }}">
    <!-- Name -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.text-input id="name" name="name" label="Name" value="{{ $product->name ?? old('name') }}"
                :required="true" minlength="3" />
        </div>
    </div>
    <!-- Brand -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.select2 id="brand_id" :options="$brands" name="brand_id" label="Brand"
                selected="{{ $product->brand_id ?? old('brand_id') }}" :required="true" />
        </div>
    </div>
    <!-- Image -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.file accept="image/jpg,image/jpeg,image/png" :multiple="true" id="image" name="images[]"
                label="Images" :required="!isset($product)" multiple />
        </div>
    </div>
    <!-- Description -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.textarea id="description" name="description" label="Description"
                value="{{ $product->description ?? old('description') }}" />
        </div>
    </div>
    @isset($product)
        <div class="col-md-12">
            <x-forms.label for="me" text="Current Images" :required="false" />
            <div class="row">
                @foreach ($product->media as $image)
                <div class="col-md-3 position-relative">
                    <a href="{{route('merchant.product.delete-image', [ 'id' => $image->id])}}" class="bg-light text-info position-absolute top-0 end-0 m-1 text-danger delete-image" data-id="{{ $image->id }}" style="font-size: 1.5rem; text-decoration: none;">
                        &times;
                    </a>
                    <img src="{{ asset('storage/' . $image->name) }}" alt="Product Image" class="img-fluid rounded">
                </div>

                @endforeach
            </div>
        </div>
    @endisset
</x:admin.form-modal>
