@extends('layouts.app')

@section('content')
<style>
    .card {
        max-width: 800px; 
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .card {
            max-width: 100%;
        }
    }
</style>

<div class="p-3">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h1>View Academician</h1>
        <a href="{{ route('academician.index') }}" class="btn btn-secondary" style="width:200px;">Back to List</a>
    </div>

    <div class="container-sm mt-5">
        <div class="card">
            <div class="card-header">
                Academician Details
            </div>
            <div class="card-body d-flex flex-column flex-md-row justify-content-between">
                <div class="w-100 w-md-50 d-flex justify-content-center align-items-center mb-3 mb-md-0">
                    <img 
                        src="{{ $academician->user->profile_picture ? asset('storage/' . $academician->user->profile_picture) : asset('images/default_profile_picture.png') }}" 
                        alt="{{ $academician->user->name }}" 
                        class="img-thumbnail"
                        style="width: 200px; height: 200px; border-radius: 10%;">
                </div>

                <div class="w-100 w-md-50 px-3">
                    <p><strong>Staff Number:</strong> {{ $academician->staff_number }}</p>
                    <p><strong>Name:</strong> {{ $academician->user->name }}</p>
                    <p><strong>Email:</strong> {{ $academician->user->email }}</p>
                    <p><strong>College:</strong> {{ $academician->college }}</p>
                    <p><strong>Department:</strong> {{ $academician->department }}</p>
                    <p><strong>Position:</strong> {{ $academician->position }}</p>
                </div>
            </div>
            @can('admin')
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('academician.edit', $academician) }}" class="btn btn-warning flex-fill me-2">Edit</a>
                    <form action="{{ route('academician.destroy', $academician) }}" method="POST" class="flex-fill" onsubmit="return confirm('Are you sure you want to delete this record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Delete</button>
                    </form>
                </div>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <h3>Participated Projects</h3>
        <div class="table-responsive">
            @if ($grants->isEmpty())
                <p class="text-muted">This academician has not participated in any projects yet.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Start Date</th>
                            <th>Duration (Months)</th>
                            <th>Provider</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grants as $grant)
                            <tr>
                                <td>{{ $grant->title }}</td>
                                <td>${{ number_format($grant->amount, 2) }}</td>
                                <td>{{ $grant->start_date }}</td>
                                <td>{{ $grant->duration_months }}</td>
                                <td>{{ $grant->provider }}</td>
                                <td>{{ $grant->role }}</td>
                                <td>
                                    <a href="{{ route('grant.show',$grant->id) }}" class="btn btn-sm btn-info" style="width: 80px; height: 30px; font-size: 12px;">View</a>
                                    
                                    @if(auth()->user()->id === $grant->projectLeader->user->id|| auth()->user()->role === 'admin_executive')
                                        <a href="{{ route('grant.edit', $grant->id) }}" class="btn btn-sm btn-warning" style="width: 80px; height: 30px; font-size: 12px;">Edit</a>
                                    @endif
                                    @can('admin')
                                        <form action="{{ route('grant.destroy', $grant->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"style="width: 80px; height: 30px; font-size: 12px;">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
