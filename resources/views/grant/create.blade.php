@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h1>Create New Grant</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grant.store') }}" method="POST" class="row g-4">
        @csrf
        <div class="w-100">
            <label for="title" class="form-label">Title</label>
            <input 
                type="text" 
                name="title" 
                class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                value="{{ old('title') }}"
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-100">
            <label for="provider" class="form-label">Provider</label>
            <input 
                type="text" 
                name="provider" 
                class="form-control @error('provider') is-invalid @enderror" 
                id="provider" 
                value="{{ old('provider') }}"
            >
            @error('provider')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-100">
            <label for="amount" class="form-label">Amount</label>
            <input 
                type="number" 
                step="0.01"
                name="amount" 
                class="form-control @error('amount') is-invalid @enderror" 
                id="amount" 
                value="{{ old('amount') }}"
            >
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <label for="start_date" class="form-label">Start Date</label>
                <input 
                    type="date" 
                    name="start_date" 
                    class="form-control @error('start_date') is-invalid @enderror" 
                    id="start_date" 
                    value="{{ old('start_date') }}"
                >
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="duration_months" class="form-label">Duration (Months)</label>
                <input 
                    type="number" 
                    name="duration_months" 
                    class="form-control @error('duration_months') is-invalid @enderror" 
                    id="duration_months" 
                    value="{{ old('duration_months') }}"
                >
                @error('duration_months')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="w-100">
            <label for="academician_id" class="form-label">Project Leader</label>
            <select 
                name="academician_id" 
                class="form-control @error('academician_id') is-invalid @enderror" 
                id="academician_id"
            >
                <option value="">-- Select a Project Leader --</option>
                @foreach ($academicians as $academician)
                    <option 
                        value="{{ $academician->id }}" 
                        {{ old('academician_id') == $academician->id ? 'selected' : '' }}
                    >
                        {{ $academician->user->name }}
                    </option>
                @endforeach
            </select>
            @error('academician_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2 w-100">
            <label for="project_member_Ids" class="form-label">Project Members</label>
            <div class="border p-3 rounded">
                @foreach ($academicians as $academician)
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            name="project_member_Ids[]" 
                            value="{{ $academician->id }}" 
                            id="member_{{ $academician->id }}" 
                            class="form-check-input"
                            {{ (is_array(old('project_member_Ids')) && in_array($academician->id, old('project_member_Ids'))) ? 'checked' : '' }}
                        >
                        <label for="member_{{ $academician->id }}" class="form-check-label">
                            {{ $academician->user->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('project_member_Ids')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between mt-2 w-100">
            <a href="{{ route('grant.index') }}" class="btn btn-secondary w-100 me-2">Cancel</a>
            <button type="submit" class="btn btn-success w-100">Submit</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const projectLeaderDropdown = document.getElementById('academician_id');
    const memberCheckboxes = document.querySelectorAll('input[name="project_member_Ids[]"]');

    function toggleLeaderCheckbox() {
        memberCheckboxes.forEach(checkbox => {
            checkbox.disabled = false; 
            checkbox.checked = false; 
        });

        const selectedLeaderId = parseInt(projectLeaderDropdown.value);

        if (!isNaN(selectedLeaderId)) {
            const leaderCheckbox = document.getElementById(`member_${selectedLeaderId}`);
            if (leaderCheckbox) {
                leaderCheckbox.disabled = true; 
            }
        }
    }

    projectLeaderDropdown.addEventListener('change', toggleLeaderCheckbox);
    toggleLeaderCheckbox();
});
</script>
@endsection
