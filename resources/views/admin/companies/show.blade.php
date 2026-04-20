@extends('layouts.admin')

@section('title', $company->name)

@section('content')

<h3>{{ $company->name }}</h3>

<p><strong>Website:</strong>
    @if($company->website)
        <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">{{ $company->website }}</a>
    @else
        <span class="text-muted">Not set</span>
    @endif
</p>

@if($company->description)
    <p><strong>Description:</strong></p>
    <p>{{ $company->description }}</p>
@endif

<p>
    <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-primary btn-sm">Edit company</a>
    <a href="{{ route('admin.companies') }}" class="btn btn-secondary btn-sm">Back to companies</a>
</p>

@endsection
