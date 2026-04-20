<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $company = $user->company;

        $section = $request->query('section', 'my-jobs');
        $data = [];

        if ($company) {
            if ($section === 'my-jobs') {
                $data['jobs'] = $company->jobs()->orderByDesc('id')->get();
            } elseif ($section === 'applications') {
                $jobIds = $company->jobs()->pluck('id');
                $data['applications'] = Application::query()
                    ->whereIn('job_id', $jobIds)
                    ->with(['job', 'candidate'])
                    ->latest('created_at')
                    ->paginate(30);
            }
        }

        return view('company.dashboard', compact('section', 'data', 'company'));
    }
}
