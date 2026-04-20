@extends('layouts.company')

@section('title', 'Applications: '.$job->title)

@section('content')

<p class="text-muted mb-3">Company: {{ $job->company->name ?? 'N/A' }}</p>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Candidate</th>
                <th>Cover letter</th>
                <th>CV</th>
                <th>Applied at</th>
            </tr>
        </thead>
        <tbody>
            @forelse($job->applications as $application)
                <tr>
                    <td>{{ $application->candidate->name }}</td>
                    <td>
                        @if($application->cover_letter)
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#coverLetterModal{{ $application->id }}">View</button>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($application->cv_path)
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($application->cv_path) }}" target="_blank" class="btn btn-sm btn-primary">Download CV</a>
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $application->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @if($application->cover_letter)
                <div class="modal fade" id="coverLetterModal{{ $application->id }}" tabindex="-1">
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
                    <td colspan="4" class="text-center text-muted">No applications yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<a href="{{ route('company.dashboard', ['section' => 'my-jobs']) }}" class="btn btn-secondary">Back to jobs</a>

@endsection
