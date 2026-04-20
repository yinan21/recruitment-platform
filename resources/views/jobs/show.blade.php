<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $job->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $job->company->name }} · {{ $job->location ?: 'Remote / Flexible' }}@if($job->salary) · {{ $job->salary }} @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                @if($job->is_published)
                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Published</span>
                @else
                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">Draft</span>
                @endif
                <a href="{{ url('/') }}" class="text-sm text-blue-600 hover:text-blue-800">Back to listings</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="space-y-6">
                        <div class="space-y-4">
                            <div class="prose prose-slate dark:prose-invert">
                                <h3 class="text-lg font-semibold">About the role</h3>
                                <p>{!! nl2br(e($job->description)) !!}</p>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Company</h4>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $job->company->name }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Location</h4>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $job->location ?: 'Remote / Flexible' }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 md:col-span-2">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Salary</h4>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $job->salary ?: 'Not specified' }}</p>
                            </div>
                        </div>

                        <div class="rounded-lg border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-950">
                            <h4 class="text-base font-semibold text-gray-800 dark:text-gray-100">Candidate actions</h4>

                            @auth
                                @if(auth()->user()->isCandidate())
                                    @if($isApplied)
                                        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                                            You have already applied for this role.
                                        </div>
                                    @else
                                        <form method="POST" action="{{ route('jobs.apply', $job) }}" class="space-y-4" enctype="multipart/form-data">
                                            @csrf

                                            <div>
                                                <label for="cover_letter" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cover letter (optional)</label>
                                                <textarea
                                                    id="cover_letter"
                                                    name="cover_letter"
                                                    rows="4"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                                    placeholder="Write a short note about why you're a great fit..."
                                                >{{ old('cover_letter') }}</textarea>
                                                @error('cover_letter')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="cv" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Upload CV (PDF or Word)</label>
                                                <input
                                                    id="cv"
                                                    name="cv"
                                                    type="file"
                                                    accept=".pdf,.doc,.docx"
                                                    class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-200 dark:file:bg-gray-800 dark:file:text-gray-100"
                                                />
                                                @error('cv')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                                Submit Application
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-900">
                                        Only candidates can apply for this job. If you are a candidate, please use a candidate account to apply.
                                    </div>
                                @endif
                            @else
                                <div class="space-y-3">
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Please log in or register as a candidate to apply.</p>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Log in</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Register</a>
                                        @endif
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
