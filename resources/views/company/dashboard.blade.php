@extends('layouts.company')

@section('title', 'Company dashboard')

@section('content')

@if(!$company)
    <div class="alert alert-warning">
        Your account has no company profile. Please contact support.
    </div>
@elseif($section === 'my-jobs')
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['jobs'] ?? [] as $job)
                    <tr>
                        <td>{{ $job->title }}</td>
                        <td>
                            @if($job->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending approval</span>
                            @endif
                        </td>
                        <td>{{ $job->location ?: '—' }}</td>
                        <td class="text-end">
                            <a href="{{ route('company.jobs.applications', $job) }}" class="btn btn-sm btn-outline-primary">Applications</a>
                            <a href="{{ route('company.jobs.edit', $job) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">No jobs yet. Use <strong>Post a job</strong> to create one.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@elseif($section === 'applications')
    <p class="text-muted">Applications across all of your listings.</p>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Job</th>
                    <th>Candidate</th>
                    <th>Cover letter</th>
                    <th>CV</th>
                    <th>Applied</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['applications'] ?? [] as $application)
                    <tr>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ $application->candidate->name }}</td>
                        <td>
                            @if($application->cover_letter)
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#cl{{ $application->id }}">View</button>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($application->cv_path)
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($application->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Open</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $application->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @if($application->cover_letter)
                    <div class="modal fade" id="cl{{ $application->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cover letter — {{ $application->candidate->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-0">{{ $application->cover_letter }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No applications yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($data['applications']) && $data['applications']->hasPages())
        <div class="mt-3">{{ $data['applications']->links() }}</div>
    @endif
@elseif($section === 'change-profile')
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
@endif

@endsection
