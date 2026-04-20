<?php

use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Company\JobApplicationController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Company\JobController as CompanyJobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Company;
use Illuminate\Support\Facades\File;

Route::get('/_debug/logs', function () {
    abort_unless(app()->environment('local', 'production'), 403);

    $path = storage_path('logs/laravel.log');

    if (!File::exists($path)) {
        return 'No log file found';
    }

    return response(
        nl2br(e(File::get($path)))
    );
});

Route::get('/', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect('/admin');
    }

    $query = \App\Models\Job::with('company')
        ->where('is_published', true);

    // Keyword search
    if (request('keyword')) {
        $keyword = request('keyword');
        $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%')
                ->orWhere('salary', 'like', '%' . $keyword . '%');
        });
    }

    // Location filter
    if (request('location')) {
        $query->where('location', 'like', '%' . request('location') . '%');
    }

    $jobs = $query->latest()->paginate(20);

    return view('home', compact('jobs'));
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:company'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {
        Route::get('/', CompanyDashboardController::class)->name('dashboard');

        Route::get('/jobs/create', [CompanyJobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [CompanyJobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [CompanyJobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [CompanyJobController::class, 'update'])->name('jobs.update');
        Route::get('/jobs/{job}/applications', JobApplicationController::class)->name('jobs.applications');
    });

Route::middleware(['auth', 'admin_access'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::view('/', 'admin.dashboard')->name('dashboard');

        Route::view('/jobs/create', 'admin.create-job')->name('jobs.create');

        Route::view('/jobs/pending-employer', 'admin.pending-company-jobs')->name('jobs.pending-company');

        Route::get('/jobs/{job}', function (Job $job) {
            return view('admin.jobs.show', compact('job'));
        })->name('jobs.show');

        Route::get('/jobs/{job}/edit', function (App\Models\Job $job) {
            return view('admin.jobs.edit', compact('job'));
        })->name('jobs.edit');

        Route::get('/jobs/{job}/applications', function (Job $job) {
            return view('admin.jobs.applications', compact('job'));
        })->name('jobs.applications');

        Route::put('/jobs/{job}', function (Request $request, Job $job) {

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'location' => 'nullable|string|max:255',
                'salary' => 'nullable|string|max:255',
                'is_published' => 'nullable|boolean',
            ]);

            $job->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'] ?? null,
                'salary' => filled($validated['salary'] ?? null) ? trim($validated['salary']) : null,
                'is_published' => $request->boolean('is_published'),
            ]);

            return redirect()
                ->route('admin.jobs')
                ->with('success', 'Job updated successfully');

        })->name('jobs.update');

        Route::view('/jobs', 'admin.jobs')->name('jobs');
        Route::view('/companies', 'admin.companies')->name('companies');
        Route::view('/companies/create', 'admin.create-company')->name('companies.create');

        Route::get('/companies/{company}', function (Company $company) {
            return view('admin.companies.show', compact('company'));
        })->name('companies.show');

        Route::get('/companies/{company}/edit', function (\App\Models\Company $company) {
            return view('admin.companies.edit', compact('company'));
        })->name('companies.edit');

        Route::put('/companies/{company}', function (Request $request, Company $company) {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'website' => 'nullable|url',
            ]);

            $company->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'website' => $validated['website'],
            ]);

            return redirect()
                ->route('admin.companies')
                ->with('success', 'Company updated successfully');

        })->name('companies.update');

        Route::get('/applications', function () {
            $applications = \App\Models\Application::query()
                ->with(['job.company', 'candidate'])
                ->latest('created_at')
                ->paginate(30);

            return view('admin.applications', compact('applications'));
        })->name('applications');

        Route::middleware('super_admin')->group(function () {
            Route::get('/staff', [AdminStaffController::class, 'index'])->name('staff.index');
            Route::post('/staff', [AdminStaffController::class, 'store'])->name('staff.store');
            Route::delete('/staff/{user}', [AdminStaffController::class, 'destroy'])->name('staff.destroy');
        });
    });

Route::get('/jobs/{job}', function (Job $job) {
    if (!$job->is_published) {
        abort(404);
    }

    $isApplied = false;

    if (auth()->check()) {
        $isApplied = $job->applications()
            ->where('candidate_id', auth()->id())
            ->exists();
    }

    return view('jobs.show', compact('job', 'isApplied'));
})->name('jobs.show');

Route::post('/jobs/{job}/apply', function (Request $request, Job $job) {
    if (!$job->is_published) {
        abort(404);
    }

    $user = $request->user();

    if (! $user->isCandidate()) {
        abort(403);
    }

    if ($job->applications()->where('candidate_id', $user->id)->exists()) {
        return redirect()->route('jobs.show', $job)
            ->with('status', 'You have already applied to this job.');
    }

    $validated = $request->validate([
        'cover_letter' => 'nullable|string',
        'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
    ]);

    $cvPath = null;

    if ($request->hasFile('cv')) {
        $cvPath = Storage::putFile('cvs', $request->file('cv'));
    }

    $job->applications()->create([
        'candidate_id' => $user->id,
        'cover_letter' => $validated['cover_letter'] ?? null,
        'cv_path' => $cvPath,
    ]);

    return redirect()->route('jobs.show', $job)
        ->with('success', 'Your application was submitted successfully.');
})->middleware(['auth', 'role:candidate'])->name('jobs.apply');

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect('/admin');
    }

    if (auth()->user()->isCompany()) {
        return redirect()->route('company.dashboard');
    }

    if (auth()->user()->isCandidate()) {
        $section = request('section', 'find-job');
        $data = [];

        if ($section === 'find-job') {
            $query = \App\Models\Job::with('company')
                ->where('is_published', true);

            // Keyword search
            if (request('keyword')) {
                $keyword = request('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%')
                        ->orWhere('salary', 'like', '%' . $keyword . '%');
                });
            }

            // Location filter
            if (request('location')) {
                $query->where('location', 'like', '%' . request('location') . '%');
            }

            $data['jobs'] = $query->latest()->paginate(20);
        } elseif ($section === 'my-applications') {
            $data['applications'] = auth()->user()->applications()->with('job.company')->latest()->get();
        }

        return view('candidate.dashboard', compact('section', 'data'));
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';
