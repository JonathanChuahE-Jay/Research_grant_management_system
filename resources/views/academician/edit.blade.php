@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Academician</h1>

    <form action="{{ route('academician.update', $academician) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="text-center mb-3">
            <label for="profile_picture_input" style="cursor: pointer;">
                <img 
                    src="{{ $academician->user->profile_picture ? asset('storage/' . $academician->user->profile_picture) : asset('images/default_profile_picture.png') }}" 
                    class="img-thumbnail" 
                    alt="Profile Picture" 
                    style="width: 120px; height: 120px; border-radius: 50%;">
            </label>
            <input id="profile_picture_input" name="profile_picture" type="file" class="d-none" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="staff_number" class="form-label">Staff Number</label>
            <input 
                type="text" 
                name="staff_number" 
                id="staff_number" 
                class="form-control @error('staff_number') is-invalid @enderror" 
                value="{{ old('staff_number', $academician->staff_number) }}" 
                required>
            @error('staff_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name', $academician->user->name) }}" 
                required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $academician->user->email) }}" 
                required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="college" class="form-label">College</label>
            <input 
                type="text" 
                name="college" 
                id="college" 
                class="form-control @error('college') is-invalid @enderror" 
                value="{{ old('college', $academician->college) }}" 
                required>
            @error('college')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input 
                type="text" 
                name="department" 
                id="department" 
                class="form-control @error('department') is-invalid @enderror" 
                value="{{ old('department', $academician->department) }}" 
                required>
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
                <option value="Lecturer" {{ old('position', $academician->position) == 'Lecturer' ? 'selected' : '' }}>{{ __('Lecturer') }}</option>
                <option value="Senior Lecturer" {{ old('position', $academician->position) == 'Senior Lecturer' ? 'selected' : '' }}>{{ __('Senior Lecturer') }}</option>
                <option value="Assoc Prof" {{ old('position', $academician->position) == 'Assoc Prof' ? 'selected' : '' }}>{{ __('Associate Professor') }}</option>
                <option value="Professor" {{ old('position', $academician->position) == 'Professor' ? 'selected' : '' }}>{{ __('Professor') }}</option>
            </select>
            @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('academician.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const profilePictureInput = document.getElementById("profile_picture_input");
        const profilePictureImage = document.querySelector("label[for='profile_picture_input'] img");

        profilePictureInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    profilePictureImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
