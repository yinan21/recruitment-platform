@extends('layouts.admin')

@section('title', 'Edit Company')

@section('content')

<h3>Edit: {{ $company->name }}</h3>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.companies.update', $company->id) }}">
    @csrf
    @method('PUT')

    {{-- NAME --}}
    <div class="mb-3">
        <label>Company Name</label>
        <input type="text" name="name"
               class="form-control"
               value="{{ old('name', $company->name) }}">

        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- DESCRIPTION --}}
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description"
                  class="form-control"
                  rows="5">{{ old('description', $company->description) }}</textarea>

        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- WEBSITE --}}
    <div class="mb-3">
        <label>Website</label>
        <input type="url" name="website"
               class="form-control"
               value="{{ old('website', $company->website) }}">
        @error('website') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Save Changes
    </button>

    <a href="{{ route('admin.companies') }}" class="btn btn-secondary">
        Cancel
    </a>

</form>

@endsection