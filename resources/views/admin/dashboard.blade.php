@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="row">

    <div class="col-md-4">
        <a href="{{ route('admin.jobs') }}" class="text-decoration-none">
            <div class="card p-3">
                <h5>Total Jobs</h5>
                <h2>{{ \App\Models\Job::count() }}</h2>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.companies') }}" class="text-decoration-none">
            <div class="card p-3">
                <h5>Companies</h5>
                <h2>{{ \App\Models\Company::count() }}</h2>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.applications') }}" class="text-decoration-none">
            <div class="card p-3">
                <h5>Applications</h5>
                <h2>{{ \App\Models\Application::count() }}</h2>
            </div>
        </a>
    </div>

    @if(auth()->user()->isSuperAdmin())
        <div class="col-md-4 mt-3">
            <a href="{{ route('admin.staff.index') }}" class="text-decoration-none">
                <div class="card p-3 border-warning">
                    <h5>Manage admin users</h5>
                    <p class="text-muted small mb-0">List, add, or remove administrator accounts.</p>
                </div>
            </a>
        </div>
    @endif

</div>

@endsection