@extends('layouts.app')

@section('content')
<div class="p-3">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h1>Create New Academician</h1>
        <a href="{{ route('academician.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="container-sm">
        <div class="card">
            <div class="card-header">
                Add Academician
            </div>
            <div class="card-body">
                <form 
                    action="{{ route('academician.store') }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="text-center mb-3">
                        <label for="profile_picture_input" style="cursor: pointer;">
                            <img 
                                src="{{ old('profile_picture') 
                                    ? asset('storage/' . old('profile_picture')) 
                                    : asset('images/default_profile_picture.png') }}" 
                                class="img-thumbnail" 
                                alt="Profile Picture" 
                                style="width: 120px; height: 120px; border-radius: 50%;" 
                                id="profile_picture_preview">
                        </label>
                        <input id="profile_picture_input" name="profile_picture" type="file" class="d-none" accept="image/*">
                        @error('profile_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="staff_number" class="form-label">Staff Number</label>
                        <input 
                            type="text" 
                            id="staff_number" 
                            name="staff_number" 
                            class="form-control @error('staff_number') is-invalid @enderror" 
                            value="{{ old('staff_number') }}"
                            required
                        >
                        @error('staff_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="college" class="form-label">College</label>
                        <input 
                            type="text" 
                            id="college" 
                            name="college" 
                            class="form-control @error('college') is-invalid @enderror" 
                            value="{{ old('college') }}"
                            required
                        >
                        @error('college')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input 
                            type="text" 
                            id="department" 
                            name="department" 
                            class="form-control @error('department') is-invalid @enderror" 
                            value="{{ old('department') }}"
                            required
                        >
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
                            required
                        >
                            <option value="">Select Position</option>
                            <option value="Lecturer" {{ old('position') == 'Lecturer' ? 'selected' : '' }}>Lecturer</option>
                            <option value="Senior Lecturer" {{ old('position') == 'Senior Lecturer' ? 'selected' : '' }}>Senior Lecturer</option>
                            <option value="Assoc Prof" {{ old('position') == 'Assoc Prof' ? 'selected' : '' }}>Associate Professor</option>
                            <option value="Professor" {{ old('position') == 'Professor' ? 'selected' : '' }}>Professor</option>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('academician.index') }}" class="btn btn-secondary w-25">Cancel</a>
                        <button type="submit" class="btn btn-primary w-25">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
