<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    public function __invoke(Request $request, Job $job): View
    {
        $this->assertOwnsJob($request->user(), $job);

        $job->load(['applications.candidate', 'company']);

        return view('company.jobs.applications', compact('job'));
    }

    private function assertOwnsJob(User $user, Job $job): void
    {
        $company = $user->company;
        if (! $company || (int) $job->company_id !== (int) $company->id) {
            abort(403);
        }
    }
}
