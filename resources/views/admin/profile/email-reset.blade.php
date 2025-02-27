@extends('admin.dashboard.layout', ['title' => 'Reset Email'])

@section('content')
    <main class="body-wrapper">
        <x-admin.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'active' => false],
            ['label' => 'Reset Email', 'url' => '#', 'active' => true],
        ]" />

        <div class="page-wrapper">
            <form action="{{ route('email.reset.submit') }}" method="POST">
                @csrf
                <div class="row gy-0 gx-3">
                    <div class="col-md-6">
                        <div class="field">
                            <label for="old_email">Enter Old Email: <sup>*</sup></label>
                            <input type="email" name="old_email" id="old_email"
                                class="form-control @error('old_email') is-invalid @enderror" required
                                value="{{ old('old_email') }}">
                            @error('old_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row gy-0 gx-3">
                    <div class="col-md-6">
                        <div class="field">
                            <label for="new_email">Enter New Email: <sup>*</sup></label>
                            <input type="email" name="new_email" id="new_email"
                                class="form-control @error('new_email') is-invalid @enderror" required
                                value="{{ old('new_email') }}">
                            @error('new_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Send Reset Link</button>
            </form>

        </div>
    </main>
@endsection
