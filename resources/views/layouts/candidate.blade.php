<!DOCTYPE html>
<html>
<head>
    <title>Candidate Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">

        <h4>Candidate Dashboard</h4>

        <hr>

        <a href="{{ route('dashboard', ['section' => 'find-job']) }}" class="text-white d-block mb-2 {{ $section === 'find-job' ? 'fw-bold' : '' }}">Find Job</a>

        <a href="{{ route('dashboard', ['section' => 'my-applications']) }}" class="text-white d-block mb-2 {{ $section === 'my-applications' ? 'fw-bold' : '' }}">My Applications</a>

        <a href="{{ route('dashboard', ['section' => 'change-profile']) }}" class="text-white d-block mb-2 {{ $section === 'change-profile' ? 'fw-bold' : '' }}">Change Profile</a>
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
</body>
</html>