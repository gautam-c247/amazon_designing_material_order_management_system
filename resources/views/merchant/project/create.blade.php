<x:admin.form-modal title="{{ isset($project) ? 'Edit Project' : 'Create Project' }}"
    form-action="{{ isset($project) ? route('merchant.project.update', $project->id) : route('merchant.project.store') }}"
    method="{{ isset($project) ? 'PUT' : 'POST' }}">
    <!-- Name -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.text-input id="name" name="name" label="Name" value="{{ $project->name ?? old('name') }}"
                :required="true" minlength="3" />
        </div>
    </div>
    <!-- Brand -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.select2 id="brand_id" :options="$brands" name="brand_id" label="Brand"
                selected="{{ $project->brand_id ?? old('brand_id') }}" :required="true" />
        </div>
    </div>
    <!-- Product -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.select2 id="product_id"  name="product_id" label="Product"
                selected="{{ $project->product_id ?? old('product_id') }}" :required="true" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="field">
            <x-forms.select2 id="service_id" :options="$services" name="service_id" label="Service"
                selected="{{ $project->service_id ?? old('service_id') }}" :required="true" />
        </div>
    </div>

    <!-- Priority -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.select2 id="priority" name="priority" label="Priority"
                :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High']"
                selected="{{ $project->priority ?? old('priority') }}" :required="true" />
        </div>
    </div>
    <!-- Guidelines -->
    <div class="col-md-12">
        <div class="field">
            <x-forms.ckeditor id="guidelines" name="guidelines" label="Guidelines"
                value="{{ $project->guidelines ?? old('guidelines') }}" />
        </div>
    </div>
    <!-- Notes -->
    <div class="col-md-12">
        <div class="field">
            <x-forms.textarea id="notes" name="notes" label="Notes"
                value="{{ $project->notes ?? old('notes') }}" />
        </div>
    </div>
</x:admin.form-modal>

