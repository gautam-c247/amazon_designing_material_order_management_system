<x:admin.form-modal title="{{ isset($selectedService) ? 'Edit Service' : 'Create Service' }}"
    form-action="{{ isset($selectedService) ? route('service.update', $selectedService->id) : route('service.store') }}"
    method="{{ isset($selectedService) ? 'PUT' : 'POST' }}">
    <!-- Service Name -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.text-input id="name" name="name" label="Name" value="{{ $selectedService->name ?? old('name') }}" :required="true" />
        </div>
    </div>
    <!-- Service Description -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.textarea id="description" name="description" label="Description" value="{{ $selectedService->description ?? old('description') }}" :required="true"/>
        </div>
    </div>
    <!-- Service Credit -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.number-input id="credit" name="credit" label="Credit" value="{{ $selectedService->credit ?? old('credit') }}" :required="true" />
        </div>
    </div>
    <!-- Service Status -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.select2 id="status" :options="['1' => 'Active', '0' => 'Inactive']" name="status" label="Status" selected="{{ $selectedService->status ?? old('status') }}" :required="true" />
        </div>
    </div>
</x:admin.form-modal>
