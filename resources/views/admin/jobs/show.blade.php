@extends('layouts.admin')

@section('title', 'Job Details')

@section('content')

<h3>{{ $job->title }}</h3>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Job Information</h5>

                <p><strong>Title:</strong> {{ $job->title }}</p>
                <p><strong>Description:</strong></p>
                <p>{{ $job->description }}</p>
                <p><strong>Location:</strong> {{ $job->location ?: 'Not specified' }}</p>
                <p><strong>Status:</strong>
                    @if($job->is_published)
                        <span class="badge bg-success">Published</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </p>

                @if($job->company)
                    <p><strong>Company:</strong> <a href="{{ route('admin.companies.edit', $job->company->id) }}">{{ $job->company->name }}</a></p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Actions</h5>

                <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-primary btn-sm mb-2">Edit Job</a>
                <br>
                <a href="{{ route('admin.jobs') }}" class="btn btn-secondary btn-sm">Back to Jobs</a>
            </div>
        </div>
    </div>
</div>

@endsection