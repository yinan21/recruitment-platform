@extends('layouts.company')

@section('title', 'Edit job')

@section('content')

<h4 class="mb-3">{{ $job->title }}</h4>

@if($job->is_published)
    <div class="alert alert-info small">
        This job is live. If you change the listing content, it will return to <strong>pending</strong> until it is reviewed again.
    </div>
@endif

<form method="POST" action="{{ route('company.jobs.update', $job) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Job title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
        @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="6" required>{{ old('description', $job->description) }}</textarea>
        @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="{{ old('location', $job->location) }}">
        @error('location') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Salary</label>
        <input type="text" name="salary" class="form-control" value="{{ old('salary', $job->salary) }}">
        @error('salary') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('company.dashboard', ['section' => 'my-jobs']) }}" class="btn btn-secondary">Back</a>
</form>

@endsection
