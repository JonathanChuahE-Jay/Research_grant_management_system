@extends('layouts.app')

@section('content')
<style>
    .readonly-input[readonly] {
        cursor: not-allowed;
    }
</style>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-warning text-white text-center">
                    <h4>Edit Your Profile</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', auth()->user()) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="text-center mb-4">
                            <div class="profile-picture-container mb-2">
                                <img id="profile-picture-preview" 
                                     src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('images/default_profile_picture.png') }}" 
                                     alt="Profile Picture" 
                                     class="img-thumbnail rounded-circle" 
                                     style="width: 120px; height: 120px;">
                            </div>
                            <label for="profile_picture" class="btn btn-outline-primary btn-sm">Change Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="d-none" accept="image/*" 
                                   onchange="previewProfilePicture(event)">
                        </div>
                        <hr>
                        @if($user->role === 'project_member' && $user->academician)
                            <div class="mb-3">
                                <label for="staff_number" class="form-label">Staff Number</label>
                                <input readonly type="text" name="staff_number" id="staff_number" 
                                    class="readonly-input text-muted form-control @error('staff_number') is-invalid @enderror"
                                    value="{{ old('staff_number', $user->academician->staff_number) }}"
                                >
                                @error('staff_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', auth()->user()->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($user->role === 'project_member' && $user->academician)
                            <div class="mb-3">
                                <label for="college" class="form-label">College</label>
                                <input type="text" name="college" id="college" 
                                    class="form-control @error('college') is-invalid @enderror"
                                    value="{{ old('college', $user->academician->college) }}">
                                @error('college')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" name="department" id="department" 
                                    class="form-control @error('department') is-invalid @enderror"
                                    value="{{ old('department', $user->academician->department) }}">
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <select 
                                    id="position" 
                                    name="position" 
                                    class="form-control @error('position') is-invalid @enderror" 
                                    required>
                                    <option value="Lecturer" {{ old('position', $user->academician->position) == 'Lecturer' ? 'selected' : '' }}>{{ __('Lecturer') }}</option>
                                    <option value="Senior Lecturer" {{ old('position', $user->academician->position) == 'Senior Lecturer' ? 'selected' : '' }}>{{ __('Senior Lecturer') }}</option>
                                    <option value="Assoc Prof" {{ old('position', $user->academician->position) == 'Assoc Prof' ? 'selected' : '' }}>{{ __('Associate Professor') }}</option>
                                    <option value="Professor" {{ old('position', $user->academician->position) == 'Professor' ? 'selected' : '' }}>{{ __('Professor') }}</option>
                                </select>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <hr>
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Current Password</label>
                            <input type="password" name="old_password" id="old_password" 
                                   class="form-control @error('old_password') is-invalid @enderror"
                                   oninput="togglePasswordFields()">
                            @error('old_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="new-password-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" name="new_password" id="new_password" 
                                    class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" 
                                    class="form-control @error('confirm_password') is-invalid @enderror">
                                @error('confirm_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success w-50">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-picture-container img {
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
</style>
<script>
    function previewProfilePicture(event) {
        const input = event.target;
        const preview = document.getElementById('profile-picture-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePasswordFields() {
        const oldPassword = document.getElementById('old_password');
        const newPasswordFields = document.getElementById('new-password-fields');
        if (oldPassword.value.trim()) {
            newPasswordFields.style.display = 'block';
        } else {
            newPasswordFields.style.display = 'none';
        }
    }

    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            field.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    }
</script>

@endsection
