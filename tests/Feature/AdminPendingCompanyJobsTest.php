<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPendingCompanyJobsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_pending_employer_jobs_queue(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $employer = User::factory()->create(['role' => 'company']);
        $company = Company::create([
            'user_id' => $employer->id,
            'name' => 'Employer Co',
            'description' => null,
            'website' => null,
        ]);

        Job::create([
            'company_id' => $company->id,
            'title' => 'Queued role',
            'description' => 'Do work.',
            'location' => null,
            'salary' => null,
            'is_published' => false,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.jobs.pending-company'));

        $response->assertOk();
        $response->assertSee('Queued role');
        $response->assertSee('Employer Co');
    }

    public function test_pending_queue_hides_jobs_for_non_employer_companies(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $internalUser = User::factory()->create(['role' => 'admin']);
        $company = Company::create([
            'user_id' => $internalUser->id,
            'name' => 'Internal only',
            'description' => null,
            'website' => null,
        ]);

        Job::create([
            'company_id' => $company->id,
            'title' => 'Draft internal',
            'description' => 'X',
            'location' => null,
            'salary' => null,
            'is_published' => false,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.jobs.pending-company'));

        $response->assertOk();
        $response->assertDontSee('Draft internal');
    }
}
