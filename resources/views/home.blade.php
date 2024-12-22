@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-muted lead">Here's an overview of your activities and key statistics.</p>
    </div>

    @if(auth()->user()->role === 'admin_executive')
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Admin Executive Dashboard</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5><i class="bi bi-currency-dollar text-primary"></i> Total Grants</h5>
                                <p class="display-6 text-primary fw-bold">{{ $totalGrants }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5><i class="bi bi-people text-primary"></i> Total Academicians</h5>
                                <p class="display-6 text-primary fw-bold">{{ $totalAcademicians }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5><i class="bi bi-flag text-primary"></i> Total Milestones</h5>
                                <p class="display-6 text-primary fw-bold">{{ $totalMilestones }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('grant.index') }}" class="btn btn-primary btn-lg mx-2"><i class="bi bi-folder"></i> Manage Grants</a>
                    <a href="{{ route('milestone.index') }}" class="btn btn-primary btn-lg mx-2"><i class="bi bi-calendar-check"></i> View Milestones</a>
                    <a href="{{ route('academician.index') }}" class="btn btn-primary btn-lg mx-2"><i class="bi bi-person"></i> Manage Academicians</a>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->role === 'project_member')
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Project Member Dashboard</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <h5><i class="bi bi-clipboard text-info"></i> Assigned Grants</h5>
                        <p class="display-6 text-info fw-bold">{{ $assignedGrants }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="bi bi-activity text-info"></i> Milestones Involved</h5>
                        <p class="display-6 text-info fw-bold">{{ $milestonesInvolved }}</p>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('grant.index') }}" class="btn btn-info btn-lg mx-2"><i class="bi bi-folder"></i> View Assigned Grants</a>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            <i class="bi bi-exclamation-circle"></i> Your role is not configured for specific actions. Please contact the administrator for assistance.
        </div>
    @endif
</div>
@endsection
