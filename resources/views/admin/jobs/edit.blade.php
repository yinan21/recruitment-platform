@extends('layouts.admin')

@section('title', 'Edit Job')

@section('content')

<h3>Edit: {{ $job->title }}</h3>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($job->company)
    <p class="text-muted mb-3">
        Company:
        <a href="{{ route('admin.companies.edit', $job->company->id) }}">{{ $job->company->name }}</a>
    </p>
@endif

<form method="POST" action="{{ route('admin.jobs.update', $job->id) }}">
    @csrf
    @method('PUT')

    {{-- TITLE --}}
    <div class="mb-3">
        <label>Job Title</label>
        <input type="text" name="title"
               class="form-control"
               value="{{ old('title', $job->title) }}">

        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- DESCRIPTION --}}
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description"
                  class="form-control"
                  rows="5">{{ old('description', $job->description) }}</textarea>

        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- LOCATION --}}
    <div class="mb-3">
        <label>Location</label>
        <input type="text" name="location"
               class="form-control"
               value="{{ old('location', $job->location) }}">

        @error('location') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- SALARY --}}
    <div class="mb-3">
        <label>Salary</label>
        <input type="text" name="salary"
               class="form-control"
               value="{{ old('salary', $job->salary) }}"
               placeholder="e.g. £60,000 – £75,000 or Competitive">

        @error('salary') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- PUBLISHED --}}
    <div class="mb-3 form-check">
        <input type="checkbox" name="is_published" id="is_published" value="1" class="form-check-input"
               @checked(old('is_published', $job->is_published))>
        <label class="form-check-label" for="is_published">Published</label>

        @error('is_published') <small class="text-danger d-block">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Save Changes
    </button>

    <a href="{{ route('admin.jobs') }}" class="btn btn-secondary">
        Cancel
    </a>

</form>

@endsection
