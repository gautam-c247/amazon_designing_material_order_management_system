<x:admin.form-modal title="{{ isset($selectedNotification) ? 'Edit Notification' : 'Create Notification' }}"
    form-action="{{ isset($selectedNotification) ? route('notification.update', $selectedNotification->id) : route('notification.store') }}"
    method="{{ isset($selectedNotification) ? 'PUT' : 'POST' }}">
    <!-- Notification Title -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.text-input id="title" name="title" label="Title"
                value="{{ $selectedNotification->title ?? old('title') }}" :required="true" />
        </div>
    </div>
    <!-- Notification Message -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.textarea id="message" name="message" label="Message"
                value="{{ $selectedNotification->message ?? old('message') }}" :required="true" />
        </div>
    </div>
    <!-- Notification Recipients -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.select2 :multiple="true" id="recipients" :options="$users" name="recipients" label="Recipients"
                :selected="$selectedNotification->recipients ?? old('recipients')" :required="true" />
        </div>
    </div>
    <!-- Delivery Status -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.date-time-input id="push_time" name="push_time" label="Push Time"
    value="{{ $selectedNotification->push_time ?? old('push_time') }}" :required="true" />
        </div>
    </div>
   
</x:admin.form-modal>


