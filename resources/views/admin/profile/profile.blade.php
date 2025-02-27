@extends('admin.dashboard.layout', ['title' => 'Profile'])
@section('content')
    <main class="body-wrapper">
        <x-admin.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'active' => false],
            ['label' => 'My Profile', 'url' => '#', 'active' => true],
        ]" />
        <div class="page-wrapper">
            <!-- Page-Title -->
            <div class="row justify-content-between align-items-center mb-3">
                <div class="col-12 col-sm-auto">
                    <h1 class="m-0">My Profile</h1>
                </div>
            </div>
            <!-- Inner-wrapper -->
            <div class="inner-wrapper">
                <!-- Elements-design -->
                <div class="input-wrapper">
                    <div class="row gy-3">
                        <div class="col-lg-4 col-xl-4 col-xxl-3 col-md-8 mx-auto">
                            <div class="avatar-upload position-relative" id="dropZone">
                                <div class="avatar-preview">
                                    <div id="imagePreview"
                                        style="background-image: url('{{ isset($data['profile_picture']) && $data['profile_picture'] ? asset('storage/' . $data['profile_picture']) : asset('/admin/images/user-profile.jpg') }}');">
                                    </div>
                                </div>
                                <div
                                    class="image-upoload-action d-flex align-items-center justify-content-center gap-3 mt-4 mb-4">

                                    <div
                                        class="delete-avatar profile-delete @empty($data['profile_picture']) {{ 'd-none' }} @else  '' @endempty">
                                        <span>
                                            <span class="iconify" data-icon="fluent:delete-24-regular"></span>
                                        </span>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type='file' id="profileUpload" class="imageUpload cropper"
                                            accept=".png, .jpg, .jpeg" />
                                        <label for="profileUpload" class="">Upload Profile Image
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-xl-8 col-md-12 mx-auto">
                            <div class="user-information">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="user-info">
                                            <p>Name</p>
                                            <p class="details"><span>:</span> {{ $data['name'] }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="user-info">
                                            <p>Email</p>
                                            <p class="details"><span>:</span> {{ $data['email'] }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="user-info">
                                            <p>Phone No.</p>
                                            <p class="details"><span>:</span> {{ $data['contact_no'] ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="user-info">
                                            <p>Location</p>
                                            <p class="details"><span>:</span> {{ $data['location'] ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-end">
                                    <button class="btn btn-secondary btn-block" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" type="button" id="editProfileButton">
                                        Edit Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    {{-- user profile edit model --}}
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="edit-profile" method="POST" action="{{ route('admin.update-profile') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="iconify" data-icon="mdi:times"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row gy-0 gx-3">
                            <!-- Full Name -->
                            <div class="col-md-6">
                                <div class="field">
                                    <x-forms.label for="name" text="Full Name " :required="true" />
                                    <input type="text" id="full_name" name="name" class="form-control"
                                        value="{{ old('name', auth()->user()->name) }}" required />
                                </div>
                            </div>
                            <!-- Email (Disabled) -->
                            <div class="col-md-6">
                                <div class="field">
                                    <x-forms.label for="name" text="Email" :required="true" />
                                    <input type="email" id="email" name="email" class="form-control bg-secondary"
                                        value="{{ old('email', auth()->user()->email) }}" autocomplete="email" required
                                        disabled />
                                </div>
                            </div>
                            <!-- Contact Number -->
                            <div class="col-md-6">
                                <div class="field">
                                    <x-forms.label for="name" text="Phone Number" :required="true" />
                                    <input type="hidden" id="country_code" name="country_code" value="{{ old('country_code', auth()->user()->userDetails?->country_code) }}">

                                    <input type="tel" id="phone" name="contact_no" class="form-control"
                                        value="{{ old('contact_no', auth()->user()->userDetails?->contact_no) }}"
                                        required />
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6">
                                <div class="field">
                                    <x-forms.label for="name" text="Location" :required="true" />
                                    <input type="text" id="location" name="location" class="form-control"
                                        value="{{ old('location', auth()->user()->userDetails?->location) }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#edit-profile").on("submit", function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                var form = $(this);

                $.ajax({
                    url: "{{ route('admin.update-profile') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $(".btn-secondary").attr("disabled", true);
                    },
                    success: function(response) {
                        if (response.success) {
                            $(".details").each(function() {
                                var field = $(this).prev("p").text().trim()
                                    .toLowerCase();
                                var updatedValue = response.data[field] || "N/A";

                                if (field === "phone no.") {
                                    $(this).html("<span>:</span> " + response.data[
                                        "contact_no"]);
                                } else if (field === "location") {
                                    $(this).html("<span>:</span> " + response.data[
                                        "location"]);
                                } else {
                                    $(this).html("<span>:</span> " + updatedValue);
                                }
                            });

                            toastr.success(response.message, "Success", {
                                iconClass: "success",
                            });
                            $("#exampleModal").modal("hide");
                        } else {
                            toastr.error(response.message, "Error", {
                                iconClass: "error",
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = "Something went wrong. Please try again.";

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join(
                                "\n");
                            if (errors.name || errors.contact_no || errors.location) {
                                $("#exampleModal").modal("show");
                            }
                        }
                    },
                    complete: function() {
                        $(".btn-secondary").attr("disabled", false);
                    },
                });
            });
        });
    </script>
@endsection
