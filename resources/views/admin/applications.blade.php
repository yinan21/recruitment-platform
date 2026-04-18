@extends('layouts.admin')

@section('title', 'All Applications')

@section('content')

<div class="row">
    <div class="col-12">
        <h4>All Applications</h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Job</th>
                    <th>Candidate</th>
                    <th>Cover Letter</th>
                    <th>CV</th>
                    <th>Applied At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    <tr>
                        <td>
                            <a href="{{ route('admin.jobs.applications', $application->job) }}">{{ $application->job->title }}</a>
                        </td>
                        <td>{{ $application->candidate->name }}</td>
                        <td>
                            @if($application->cover_letter)
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#coverLetterModal{{ $application->id }}">View</button>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($application->cv_path)
                                <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="btn btn-sm btn-primary">Download CV</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $application->created_at->format('Y-m-d H:i') }}</td>
                    </tr>

                    <!-- Modal for Cover Letter -->
                    <div class="modal fade" id="coverLetterModal{{ $application->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cover Letter from {{ $application->candidate->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ $application->cover_letter }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No applications yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $applications->links() }}
    </div>
</div>

@endsection