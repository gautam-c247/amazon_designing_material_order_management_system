<x:admin.form-modal title="{{ isset($user) ? 'Edit User' : 'Create User' }}"
    form-action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
    method="{{ isset($user) ? 'PUT' : 'POST' }}">
    <!-- Full Name -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.label for="name" text="Full Name" :required="true" />
            <input type="text" id="name" name="name" class="form-control"
                value="{{ isset($user) ? $user->name : old('name') }}" />
            @error('name')
                <span class="error-message text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <!-- Email -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.label for="name" text="Email" :required="true" />
            <input type="email" id="email" name="email" class="form-control"
                value="{{ isset($user) ? $user->email : old('email') }}" />
            @error('email')
                <span class="error-message text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <!-- Location -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.label for="name" text="Location" :required="true" />
            <input type="text" id="location" name="location" class="form-control"
                value="{{ isset($user) ? $user->userDetails?->location : old('location') }}" />
            @error('location')
                <span class="error-message text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <!-- Date of Birth -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.label for="name" text="Date of Birth" :required="true" />
            <input type="text" id="date_of_birth" name="date_of_birth" class="form-control"
                value="{{ isset($user) ? $user->userDetails?->date_of_birth : old('date_of_birth') }}" />
            @error('date_of_birth')
                <span class="error-message text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <!-- Gender -->
    <div class="col-md-12">
        <div class="field">
            <x-forms.label for="name" text="Gender" :required="true" />
            <div class="checkox-wraper">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" value="Male" type="radio" name="gender" id="gender_male"
                        {{ old('gender', isset($user) ? $user->userDetails?->gender : null) == 'Male' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gender_male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" value="Female" type="radio" name="gender" id="gender_female"
                        {{ old('gender', isset($user) ? $user->userDetails?->gender : null) == 'Female' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gender_female">Female</label>
                </div>
            </div>
            @error('gender')
                <span class="error-message text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <!-- Profile Picture -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.label for="name" text="Profile Picture " :required="false" />
            <div class="custom-file">
                <input type="file" id="profile_picture" accept="image/jpeg,image/png,image/jpg"
                    name="profile_picture" class="custom-file-input">
            </div>
            @error('profile_picture')
                <span class="error-message text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <!-- Contact Number -->
    <div class="col-md-6">
        <div class="field">
            <x-forms.label for="name" text="Phone No. " :required="false" />
            <input type="hidden" id="country_code" name="country_code"
                value="{{ isset($user) ? $user->userDetails?->country_code : old('country_code') }}">
            <input type="tel" id="phone" name="contact_no" class="form-control" maxlength="10"
                value="{{ isset($user) ? $user->userDetails?->contact_no : old('contact_no') }}" />
        </div>
    </div>
</x:admin.form-modal>

</div>
</form>
