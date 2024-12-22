@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Milestone</h1>
    <form action="{{ route('milestone.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Milestone Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label for="target_completion_date" class="form-label">Target Completion Date</label>
            <input type="date" class="form-control" name="target_completion_date" required>
        </div>
        <div class="mb-3">
            <label for="deliverable" class="form-label">Deliverable</label>
            <textarea class="form-control" id="deliverable" name="deliverable" required></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Delayed">Delayed</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="remarks" class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="grant_id" class="form-label">Select Grant</label>
            <select name="grant_id" class="form-select" required>
                @if($grants->isEmpty())
                    <option value="" disabled selected>No grants available. Please contact the administrator.</option>
                @else
                    <option value="" disabled selected>Select a grant...</option>
                    @foreach ($grants as $grant)
                        <option value="{{ $grant->id }}">{{ $grant->title }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="mb-3">
            <label for="updated_date" class="form-label">Date Updated</label>
            <input type="date" class="form-control" name="updated_date" value="{{ now()->format('Y-m-d') }}" required>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('milestone.index' )}}" class="btn btn-secondary w-25">Back to Milestone</a>
            <button class="btn btn-success  w-25">Save Milestone</button>
        </div>
    </form>
</div>
@endsection
