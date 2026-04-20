<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Company') — Recruitment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>

<body>

<div class="d-flex">

    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
        <h4>Company</h4>
        <hr>
        <a href="{{ route('company.dashboard', ['section' => 'my-jobs']) }}" class="text-white d-block mb-2 {{ ($section ?? '') === 'my-jobs' ? 'fw-bold' : '' }}">My jobs</a>
        <a href="{{ route('company.dashboard', ['section' => 'applications']) }}" class="text-white d-block mb-2 {{ ($section ?? '') === 'applications' ? 'fw-bold' : '' }}">Applications</a>
        <a href="{{ route('company.jobs.create') }}" class="text-white d-block mb-2 {{ request()->routeIs('company.jobs.create', 'company.jobs.edit') ? 'fw-bold' : '' }}">Post a job</a>
        <a href="{{ route('company.dashboard', ['section' => 'change-profile']) }}" class="text-white d-block mb-2 {{ ($section ?? '') === 'change-profile' ? 'fw-bold' : '' }}">Profile</a>
        <hr>
        <a href="{{ url('/') }}" class="text-white-50 d-block mb-2 small">View public site</a>
    </div>

    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h3 class="mb-0">@yield('title')</h3>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Log out</button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
</body>
</html>
