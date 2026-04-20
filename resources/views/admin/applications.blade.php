@extends('layouts.admin')

@section('title', 'All Applications')

@section('content')

<div class="row">
    <div class="col-12">
        <h4>All Applications</h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Applied</th>
                    <th>Candidate</th>
                    <th>Job</th>
                    <th>Company</th>
                    <th>Cover Letter</th>
                    <th>CV</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    <tr>
                        <td>{{ $application->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $application->candidate->name }}</td>
                        <td>
                            @if($application->job)
                                <a href="{{ route('admin.jobs.show', $application->job) }}">{{ $application->job->title }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($application->job?->company)
                                <a href="{{ route('admin.companies.show', $application->job->company) }}">{{ $application->job->company->name }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($application->cover_letter)
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#coverLetterModal{{ $application->id }}">View</button>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($application->cv_path)
                                <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="btn btn-sm btn-primary">Download CV</a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>

                    @if($application->cover_letter)
                        <div class="modal fade" id="coverLetterModal{{ $application->id }}" tabindex="-1" aria-labelledby="coverLetterModalLabel{{ $application->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="coverLetterModalLabel{{ $application->id }}">Cover letter — {{ $application->candidate->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <td colspan="6" class="text-center">No applications yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $applications->links() }}
    </div>
</div>

@endsection
