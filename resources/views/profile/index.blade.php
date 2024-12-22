@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h4>User Profile</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="profile-picture-container">
                            <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('images/default_profile_picture.png') }}" 
                                 alt="Profile Picture" 
                                 class="img-thumbnail rounded-circle" 
                                 style="width: 120px; height: 120px;">
                        </div>
                        <h5 class="mt-3">{{ auth()->user()->name }}</h5>
                        <p class="text-muted">{{ auth()->user()->role }}</p>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Email:</strong>
                                <p class="text-muted">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Role:</strong>
                                <p class="text-muted">{{ auth()->user()->role }}</p>
                            </div>
                            @if(auth()->user()->role === 'project_member')
                                <div class="col-md-6">
                                    <strong>College:</strong>
                                    <p class="text-muted">{{ auth()->user()->academician->college }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Department:</strong>
                                    <p class="text-muted">{{ auth()->user()->academician->department }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Position:</strong>
                                    <p class="text-muted">{{ auth()->user()->academician->position }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('user.edit', auth()->user()) }}" class="btn btn-warning flex-fill me-2">Edit Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="flex-fill">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">Logout</button>
                        </form>
                    </div>
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
@endsection
