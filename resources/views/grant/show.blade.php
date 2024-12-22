@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Grant Details</h1>
        <a href="{{ route('grant.index') }}" class="btn btn-secondary">Back to Grants</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>{{ $grant->title }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Amount: </strong> ${{ number_format($grant->amount, 2) }}</p>
            <p><strong>Start Date: </strong> {{ $grant->start_date->format('d M, Y') }}</p>
            <p><strong>Provider: </strong>{{ $grant->provider }}</p>
            <p><strong>Duration (Months): </strong>{{ $grant->duration_months }}</p>
            <p><strong>Project Leader: </strong>{{ $grant->projectLeader->user->name ?? 'N/A' }}</p>
        </div>
        <hr>
        <div class="card-body">
            <h5>Project Members:</h5>
            @if ($members->isEmpty())
                <p>No members have been assigned to this grant.</p>
            @else
                <ul class="list-group">
                    @foreach ($members as $member)
                        <li class="list-group-item">
                            {{ $member->user->name }}
                        </li>
                    @endforeach
                </ul>
            @endif
            <div class="mt-3">
                {{ $members->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <hr>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="mb-3">All Milestones:</h5>
                @if(auth()->user()->id === $grant->projectLeader->user->id || auth()->user()->role === 'admin_executive')
                    <a href="{{ route('milestone.create', ['grant' => $grant->id]) }}" class="btn btn-primary" style="width:200px; height:30px; font-size: 13px;">Create New Milestone</a>
                @endif
            </div>
            @if ($milestones->isEmpty())
                <p>No milestones available for this grant.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Target Completion Date</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($milestones as $milestone)
                            <tr>
                                <td>{{ $milestone->name }}</td>
                                <td>{{ $milestone->target_completion_date->format('d M, Y') }}</td>
                                <td>{{ $milestone->status }}</td>
                                <td>{{ $milestone->remarks }}</td>
                                <td>
                                    @if(auth()->user()->id === $grant->projectLeader->user->id|| auth()->user()->role === 'admin_executive')
                                        <a href="{{ route('milestone.edit', $milestone) }}" class="btn btn-sm btn-warning" style="width: 80px; height: 30px; font-size: 12px;">Edit</a>
                                        <form action="{{ route('milestone.destroy', $milestone) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" style="width: 80px; height: 30px; font-size: 12px;">Delete</button>
                                        </form>
                                    @else
                                        <span class="text-muted">No action available</span>
                                    @endif
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
