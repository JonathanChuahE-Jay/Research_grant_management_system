@extends('layouts.app')

@section('content')
<div class="p-3">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h1>List of Academicians</h1>
        @can('admin')
            <a href="{{ route('academician.create') }}" class="btn btn-primary">Create New Academician</a>
        @endcan
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Staff Number</th>
                <th>Name</th>
                <th>Email</th>
                <th>College</th>
                <th>Department</th>
                <th>Position</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($academicians->count() > 0)
                @foreach ($academicians as $index => $academician )
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $academician->staff_number }}</td>
                        <td>{{ $academician->user->name }}</td>
                        <td>{{ $academician->user->email }}</td>
                        <td>{{ $academician->college }}</td>
                        <td>{{ $academician->department }}</td>
                        <td>{{ $academician->position }}</td>
                        <td>
                            <a href="{{ route('academician.show', $academician) }}" class="btn btn-info" style="width: 80px; height: 30px; font-size: 12px;">View</a>
                            @can('admin')
                                <a href="{{ route('academician.edit', $academician) }}" class="btn btn-warning" style="width: 80px; height: 30px; font-size: 12px;">Edit</a>
                                
                                <form action="{{ route('academician.destroy',$academician) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="width: 80px; height: 30px; font-size: 12px;">Delete</button>
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
        {{ $academicians->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
