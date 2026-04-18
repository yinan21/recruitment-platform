<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>

<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">

        <h4>Admin Panel</h4>

        <hr>

        <a href="{{ route('admin.dashboard') }}" class="text-white d-block mb-2">Dashboard</a>

        <a href="{{ route('admin.jobs') }}" class="text-white d-block mb-2">Jobs</a>

        <a href="{{ route('admin.companies') }}" class="text-white d-block mb-2">Companies</a>

        <a href="{{ route('admin.jobs.create') }}" class="text-white d-block mb-2">Create Job</a>

        <a href="{{ route('admin.companies.create') }}" class="text-white d-block mb-2">Create Company</a>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="flex-grow-1 p-4">

        {{-- TOPBAR --}}
        <div class="d-flex justify-content-between mb-3">
            <h3>@yield('title')</h3>

            <form method="POST" action="/logout">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>

        @yield('content')

    </div>

</div>

@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>