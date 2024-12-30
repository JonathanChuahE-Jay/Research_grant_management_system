@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Milestones</h1>
        <a href="{{ route('milestone.create') }}" class="btn btn-primary">Create New Milestone</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Target Completion Date</th>
                <th>Deliverable</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Grant</th>
                <th>Updated date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($milestones as $milestone)
                <tr>
                    <td>{{ $milestone->name }}</td>
                    <td>{{ $milestone->target_completion_date->format('d M, Y') }}</td>
                    <td>{{ $milestone->deliverable ?? 'N/A'}}</td>
                    <td>
                        @php
                            $statusClasses = [
                                'Pending' => 'bg-warning text-dark',
                                'In Progress' => 'bg-primary text-white',
                                'Completed' => 'bg-success text-white',
                                'Delayed' => 'bg-danger text-white'
                            ];
                        @endphp
                        <span class="badge rounded-pill {{ $statusClasses[$milestone->status] ?? 'bg-secondary text-white' }}">
                            {{ $milestone->status }}
                        </span>
                    </td>
                    <td>{{ $milestone->remarks ?? 'N/A' }}</td>
                    <td>{{ $milestone->grant->title ?? 'N/A' }}</td>
                    <td>{{ $milestone->updated_date->format('d M, Y') }}</td>
                    <td>
                        @can('update', $milestone)
                            <a href="{{ route('milestone.edit', $milestone) }}" class="btn btn-sm btn-warning" style="width: 80px; height: 30px; font-size: 12px;">Edit</a>
                        @endcan

                        @can('delete', $milestone)
                            <form action="{{ route('milestone.destroy', $milestone) }}" method="POST" style="display:inline;"onsubmit="return confirm('Are you sure you want to delete this record?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" style="width: 80px; height: 30px; font-size: 12px;">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No milestones available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $milestones->links() }}
    </div>
</div>
@endsection
