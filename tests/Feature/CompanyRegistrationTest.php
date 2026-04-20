<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_registration_screen_renders(): void
    {
        $response = $this->get('/register/company');

        $response->assertStatus(200);
    }

    public function test_company_can_register_and_company_row_is_created(): void
    {
        $response = $this->post('/register/company', [
            'name' => 'Pat Employer',
            'email' => 'employer@example.com',
            'mobile_no' => '+44 7700 900001',
            'password' => 'password',
            'password_confirmation' => 'password',
            'company_name' => 'Acme Ltd',
            'company_description' => 'We hire great people.',
            'company_website' => 'https://acme.example',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('company.dashboard', absolute: false));

        $user = User::where('email', 'employer@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('company', $user->role);

        $this->assertDatabaseHas('companies', [
            'user_id' => $user->id,
            'name' => 'Acme Ltd',
        ]);

        $this->assertInstanceOf(Company::class, $user->company);
    }
}
