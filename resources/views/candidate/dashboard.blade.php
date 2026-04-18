@extends('layouts.candidate')

@section('title', 'Candidate Dashboard')

@section('content')

@if($section === 'find-job')
    <div class="row">
        <div class="col-12">
            <h4>Find Jobs</h4>
            <form method="GET" class="d-flex gap-2 mb-3">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search jobs..." class="form-control">
                <input type="text" name="location" value="{{ request('location') }}" placeholder="Location..." class="form-control">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <div class="row">
                @forelse($data['jobs'] ?? [] as $job)
                    <div class="col-md-12 mb-3">
                        <div class="card p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5><a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">{{ $job->title }}</a></h5>
                                    <p class="text-muted">{{ $job->company->name }} · {{ $job->location ?: 'Remote / Flexible' }}</p>
                                    <p class="text-truncate">{{ strip_tags($job->description) }}</p>
                                </div>
                                <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No jobs found.</p>
                @endforelse
            </div>
            @if(isset($data['jobs']) && $data['jobs']->hasPages())
                <div class="mt-3">
                    {{ $data['jobs']->links() }}
                </div>
            @endif
        </div>
    </div>
@elseif($section === 'my-applications')
    <div class="row">
        <div class="col-12">
            <h4>My Applications</h4>
            <div class="row">
                @forelse($data['applications'] ?? [] as $application)
                    <div class="col-md-12 mb-3">
                        <div class="card p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5><a href="{{ route('jobs.show', $application->job) }}" class="text-decoration-none">{{ $application->job->title }}</a></h5>
                                    <p class="text-muted">{{ $application->job->company->name }} · {{ $application->job->location ?: 'Remote / Flexible' }}</p>
                                    @if($application->cover_letter)
                                        <p>Cover letter: {{ Str::limit(strip_tags($application->cover_letter), 100) }}</p>
                                    @endif
                                    @if($application->cv_path)
                                        <p>CV uploaded</p>
                                    @endif
                                </div>
                                <span class="badge bg-success">Applied</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">You haven't applied to any jobs yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@elseif($section === 'change-profile')
    <div class="row">
        <div class="col-12">
            <h4>Change Profile</h4>
            @php $user = auth()->user() @endphp
            <div class="row">
                <div class="col-md-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="col-md-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endif

@endsection