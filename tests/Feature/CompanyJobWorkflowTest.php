<?php

namespace Tests\Feature;

use App\Mail\JobReturnedToPendingMail;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CompanyJobWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function makeCompanyUser(): array
    {
        $user = User::factory()->create([
            'role' => 'company',
        ]);

        $company = Company::create([
            'user_id' => $user->id,
            'name' => 'Widget Co',
            'description' => null,
            'website' => null,
        ]);

        return [$user, $company];
    }

    public function test_new_job_is_pending(): void
    {
        [$user, $company] = $this->makeCompanyUser();

        $this->actingAs($user)->post(route('company.jobs.store'), [
            'title' => 'Engineer',
            'description' => 'Build features.',
            'location' => 'Remote',
            'salary' => '£60k',
        ])->assertRedirect(route('company.dashboard', ['section' => 'my-jobs'], absolute: false));

        $job = Job::where('title', 'Engineer')->first();
        $this->assertNotNull($job);
        $this->assertSame((int) $company->id, (int) $job->company_id);
        $this->assertFalse($job->is_published);
    }

    public function test_editing_published_job_without_content_change_stays_published(): void
    {
        [$user, $company] = $this->makeCompanyUser();

        $job = Job::create([
            'company_id' => $company->id,
            'title' => 'Analyst',
            'description' => 'Analyze.',
            'location' => 'London',
            'salary' => null,
            'is_published' => true,
        ]);

        $this->actingAs($user)->put(route('company.jobs.update', $job), [
            'title' => 'Analyst',
            'description' => 'Analyze.',
            'location' => 'London',
            'salary' => '',
        ]);

        $job->refresh();
        $this->assertTrue($job->is_published);
    }

    public function test_editing_published_job_with_content_change_sets_pending(): void
    {
        [$user, $company] = $this->makeCompanyUser();

        $job = Job::create([
            'company_id' => $company->id,
            'title' => 'Analyst',
            'description' => 'Analyze.',
            'location' => 'London',
            'salary' => null,
            'is_published' => true,
        ]);

        Mail::fake();

        User::factory()->create([
            'role' => 'admin',
            'email' => 'admin-notify@example.com',
        ]);

        $this->actingAs($user)->put(route('company.jobs.update', $job), [
            'title' => 'Senior Analyst',
            'description' => 'Analyze.',
            'location' => 'London',
            'salary' => '',
        ]);

        $job->refresh();
        $this->assertFalse($job->is_published);

        Mail::assertSent(JobReturnedToPendingMail::class, fn (JobReturnedToPendingMail $m) => $m->toAdmin === true);
        Mail::assertSent(JobReturnedToPendingMail::class, fn (JobReturnedToPendingMail $m) => $m->toAdmin === false);
    }

    public function test_company_cannot_update_another_companies_job(): void
    {
        [$user] = $this->makeCompanyUser();

        $otherCompany = Company::create([
            'user_id' => User::factory()->create(['role' => 'company'])->id,
            'name' => 'Other',
            'description' => null,
            'website' => null,
        ]);

        $job = Job::create([
            'company_id' => $otherCompany->id,
            'title' => 'Other job',
            'description' => 'Desc',
            'location' => null,
            'salary' => null,
            'is_published' => true,
        ]);

        $this->actingAs($user)->put(route('company.jobs.update', $job), [
            'title' => 'Hacked',
            'description' => 'No',
            'location' => null,
            'salary' => null,
        ])->assertForbidden();
    }
}
