@extends('layouts.company')

@section('title', 'Post a job')

@section('content')

<form method="POST" action="{{ route('company.jobs.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Job title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
        @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="e.g. London or Remote">
        @error('location') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Salary</label>
        <input type="text" name="salary" class="form-control" value="{{ old('salary') }}" placeholder="Optional">
        @error('salary') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <p class="text-muted small">New listings are saved as <strong>pending</strong> until an administrator publishes them.</p>

    <button type="submit" class="btn btn-primary">Submit job</button>
    <a href="{{ route('company.dashboard', ['section' => 'my-jobs']) }}" class="btn btn-secondary">Cancel</a>
</form>

@endsection
