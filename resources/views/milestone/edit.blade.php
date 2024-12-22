@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-warning text-white text-center">
                    <h4>Edit Milestone</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('milestone.update', $milestone->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Milestone Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                   value="{{ old('name', $milestone->name) }}" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="target_completion_date" class="form-label">Target Completion Date</label>
                            <input type="date" id="target_completion_date" name="target_completion_date" class="form-control"
                                   value="{{ old('target_completion_date', $milestone->target_completion_date->format('Y-m-d')) }}" required>
                            @error('target_completion_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deliverable" class="form-label">Deliverable</label>
                            <input type="text" id="deliverable" name="deliverable" class="form-control"
                                   value="{{ old('deliverable', $milestone->deliverable) }}" required>
                            @error('deliverable')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="Pending" {{ $milestone->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $milestone->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $milestone->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Delayed" {{ $milestone->status == 'Delayed' ? 'selected' : '' }}>Delayed</option>
                            </select>
                            @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea id="remarks" name="remarks" class="form-control" rows="3">{{ old('remarks', $milestone->remarks) }}</textarea>
                            @error('remarks')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="updated_date" class="form-label">Date Updated</label>
                            <input type="date" class="form-control" name="updated_date" value="{{ old('updated_date', $milestone->updated_date->format('Y-m-d')) }}"  required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('milestone.index') }}" class="btn btn-secondary w-25">Back to Milestone</a>
                            <button type="submit" class="btn btn-success w-25">Update Milestone</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
