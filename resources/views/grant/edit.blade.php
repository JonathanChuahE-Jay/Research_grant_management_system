@extends('layouts.app')

@section('content')
<style>
    input[readonly], select[disabled], input[disabled] {
        cursor: not-allowed;
    }
</style>
<div class="container">
    <div class="mb-3">
        <h1>Edit Grant</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Edit Grant: {{ $grant->title }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('grant.update', $grant->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        class="form-control" 
                        value="{{ old('title', $grant->title) }}" 
                        @if(auth()->user()->role !== 'admin_executive') readonly @endif 
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input 
                        type="number" 
                        id="amount" 
                        name="amount" 
                        class="form-control" 
                        step="0.01" 
                        value="{{ old('amount', $grant->amount) }}" 
                        @if(auth()->user()->role !== 'admin_executive') readonly @endif 
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input 
                        type="date" 
                        id="start_date" 
                        name="start_date" 
                        class="form-control" 
                        value="{{ old('start_date', $grant->start_date ? $grant->start_date->format('Y-m-d') : '') }}" 
                        @if(auth()->user()->role !== 'admin_executive') readonly @endif 
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="provider" class="form-label">Provider</label>
                    <input 
                        type="text" 
                        id="provider" 
                        name="provider" 
                        class="form-control" 
                        value="{{ old('provider', $grant->provider) }}" 
                        @if(auth()->user()->role !== 'admin_executive') readonly @endif 
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="duration_months" class="form-label">Duration (Months)</label>
                    <input 
                        type="number" 
                        id="duration_months" 
                        name="duration_months" 
                        class="form-control" 
                        value="{{ old('duration_months', $grant->duration_months) }}" 
                        @if(auth()->user()->role !== 'admin_executive') readonly @endif 
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="academician_id" class="form-label">Project Leader</label>
                    <select 
                        id="academician_id" 
                        name="academician_id" 
                        class="form-select" 
                        @if(auth()->user()->role !== 'admin_executive') disabled @endif
                    >
                        <option value="">-- Select Project Leader --</option>
                        @foreach($academicians as $academician)
                            <option value="{{ $academician->id }}" 
                                {{ old('academician_id', $grant->academician_id) == $academician->id ? 'selected' : '' }}
                            >
                                {{ $academician->user->name }}
                            </option>
                        @endforeach
                    </select>

                    @if(auth()->user()->role !== 'admin_executive')
                        <input type="hidden" name="academician_id" value="{{ $grant->academician_id }}">
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Project Members</label>
                    <div class="border p-3 rounded">
                        @foreach ($academicians as $academician)
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    name="project_member_Ids[]" 
                                    value="{{ $academician->id }}" 
                                    id="member_{{ $academician->id }}" 
                                    class="form-check-input" 
                                    {{ in_array($academician->id, old('project_member_Ids', $grant->projectMembers->pluck('id')->toArray())) ? 'checked' : '' }}
                                    @if(auth()->user()->role !== 'admin_executive') disabled @endif
                                >
                                <label for="member_{{ $academician->id }}" class="form-check-label">
                                    {{ $academician->user->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-end mt-3 d-flex justify-content-between">
                    <a href="{{ route('grant.index') }}" class="btn btn-secondary w-25">Back to Grants</a>
                    <button type="submit" class="btn btn-primary w-25">Update Grant</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const projectLeaderDropdown = document.getElementById('academician_id');
    const memberCheckboxes = document.querySelectorAll('input[name="project_member_Ids[]"]');

    function toggleLeaderCheckbox() {
        const selectedLeaderId = parseInt(projectLeaderDropdown.value);

        memberCheckboxes.forEach(checkbox => {
            checkbox.disabled = false;
        });

        if (!isNaN(selectedLeaderId)) {
            const leaderCheckbox = document.getElementById(`member_${selectedLeaderId}`);
            if (leaderCheckbox) {
                leaderCheckbox.disabled = true;
                leaderCheckbox.checked = false;
            }
        }
    }

    projectLeaderDropdown.addEventListener('change', toggleLeaderCheckbox);
    toggleLeaderCheckbox();
});
</script>
@endsection
