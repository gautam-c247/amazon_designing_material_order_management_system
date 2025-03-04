<x:admin.form-modal title="{{ isset($user) ? 'Edit User' : 'Create User' }}"
    form-action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
    method="{{ isset($user) ? 'PUT' : 'POST' }}">
    <!-- Full Name -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.text-input id="name" name="name" label="Full Name" value="{{isset($user) ? $user->name : ''}}" :required="true" />
        </div>
    </div>
     <!-- Email -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.email-input id="email" name="email" label="Email" :required="true" value="{{isset($user) ? $user->email : ''}}"/>
        </div>
    </div>
   {{-- Role --}}
    <div class="col-md-4">
        <div class="field">
            <x-forms.select2 id="role" :options="['admin' => 'Admin', 'merchant' => 'Merchant', 'designer' => 'Designer']" name="role" label="Role" selected="{{isset($user->roles[0]->name) ? $user->roles[0]->name : ''}}" :required="true"/>
        </div>
    </div>
    {{-- Status --}}
    <div class="col-md-4">
        <div class="field">
            <x-forms.select2 id="status" :options="['1' => 'Active', '0' => 'Inactive']" name="status" label="Status" selected="{{isset($user->status) ? $user->status : ''}}" :required="true"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="field">
        <x-forms.password-input id="password" label="Password"  name="password" :required="true" />
        </div>
    </div>
</x:admin.form-modal>

</div>
</form>
