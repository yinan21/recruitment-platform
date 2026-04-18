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

</div>

@endsection