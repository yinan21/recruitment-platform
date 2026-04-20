<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Mail\JobReturnedToPendingMail;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class JobController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $company = $request->user()->company;
        if (! $company) {
            return redirect()
                ->route('company.dashboard')
                ->with('error', 'No company profile is linked to your account.');
        }

        return view('company.jobs.create', compact('company'));
    }

    public function store(Request $request): RedirectResponse
    {
        $company = $request->user()->company;
        if (! $company) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
        ]);

        $company->jobs()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'] ?? null,
            'salary' => $this->normalizedSalary($validated['salary'] ?? null),
            'is_published' => false,
        ]);

        return redirect()
            ->route('company.dashboard', ['section' => 'my-jobs'])
            ->with('success', 'Job submitted as pending. It will appear publicly after approval.');
    }

    public function edit(Request $request, Job $job): View
    {
        $this->assertOwnsJob($request->user(), $job);

        return view('company.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->assertOwnsJob($request->user(), $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
        ]);

        $newSalary = $this->normalizedSalary($validated['salary'] ?? null);
        $newLocation = $validated['location'] ?? null;

        $contentChanged = $job->title !== $validated['title']
            || $job->description !== $validated['description']
            || ($job->location ?? '') !== ($newLocation ?? '')
            || ($this->normalizedSalary($job->salary) ?? '') !== ($newSalary ?? '');

        $wasPublished = $job->is_published;

        $job->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $newLocation,
            'salary' => $newSalary,
            'is_published' => $wasPublished && ! $contentChanged,
        ]);

        if ($wasPublished && $contentChanged) {
            $job->loadMissing('company.user');
            $this->notifyJobReturnedToPending($job);
        }

        $message = $wasPublished && $contentChanged
            ? 'Job updated. It is pending approval again because the listing content changed.'
            : 'Job updated successfully.';

        return redirect()
            ->route('company.dashboard', ['section' => 'my-jobs'])
            ->with('success', $message);
    }

    private function assertOwnsJob(User $user, Job $job): void
    {
        $company = $user->company;
        if (! $company || (int) $job->company_id !== (int) $company->id) {
            abort(403);
        }
    }

    private function normalizedSalary(?string $salary): ?string
    {
        if ($salary === null || trim($salary) === '') {
            return null;
        }

        return trim($salary);
    }

    private function notifyJobReturnedToPending(Job $job): void
    {
        foreach (User::query()->where('role', 'admin')->whereNotNull('email')->cursor() as $admin) {
            Mail::to($admin->email)->send(new JobReturnedToPendingMail($job, true));
        }

        $owner = $job->company?->user;
        if ($owner && $owner->email) {
            Mail::to($owner->email)->send(new JobReturnedToPendingMail($job, false));
        }
    }
}
