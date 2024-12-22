@extends('layouts.app')

@section('content')
<div class="p-3">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h1>List of Grants</h1>
        @can('admin')
            <a href="{{ route('grant.create') }}" class="btn btn-primary">Create New Grant</a>
        @endcan
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Provider</th>
                <th>Amount</th>
                <th>Start Date</th>
                <th>Duration (Months)</th>
                <th>Project Leader</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($grants->count() > 0)
                @foreach ($grants as $index => $grant)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $grant->title }}</td>
                        <td>{{ $grant->provider }}</td>
                        <td>${{ number_format($grant->amount, 2) }}</td>
                        <td>{{ $grant->start_date->format('d M, Y') }}</td>
                        <td>{{ $grant->duration_months }}</td>
                        <td>{{ $grant->projectLeader->user->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('grant.show', $grant->id) }}" class="btn btn-sm btn-info" style="width: 80px; height: 30px; font-size: 12px;">View</a>
                            @if(auth()->user()->id === $grant->projectLeader->user->id || auth()->user()->role === 'admin_executive')
                                <a href="{{ route('grant.edit', $grant->id) }}" class="btn btn-sm btn-warning" style="width: 80px; height: 30px; font-size: 12px;">Edit</a>
                            @endif
                            @can('admin')
                                <form action="{{ route('grant.destroy', $grant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="width: 80px; height: 30px; font-size: 12px;">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">-- NO DATA --</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $grants->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
