<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Hash;

class AdminTestSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Super admin (can manage other admin accounts)
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'mobile_no' => '+44 7700 900099',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // 🔹 Admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'mobile_no' => '+44 7700 900100',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // 🔹 Active Company
        $companyUser1 = User::create([
            'name' => 'Tech Corp User',
            'email' => 'company1@test.com',
            'mobile_no' => '+44 7700 900101',
            'password' => Hash::make('password'),
            'role' => 'company',
            'is_active' => true,
        ]);

        $company1 = Company::create([
            'user_id' => $companyUser1->id,
            'name' => 'Tech Corp',
        ]);

        // 🔹 Inactive Company
        $companyUser2 = User::create([
            'name' => 'Startup User',
            'email' => 'company2@test.com',
            'mobile_no' => '+44 7700 900102',
            'password' => Hash::make('password'),
            'role' => 'company',
            'is_active' => false,
        ]);

        $company2 = Company::create([
            'user_id' => $companyUser2->id,
            'name' => 'Startup Inc',
        ]);

        // 🔹 Candidate users (for applications)
        $candidate1 = User::create([
            'name' => 'Alex Rivera',
            'email' => 'candidate1@test.com',
            'mobile_no' => '+44 7700 900201',
            'password' => Hash::make('password'),
            'role' => 'candidate',
            'is_active' => true,
        ]);

        $candidate2 = User::create([
            'name' => 'Jordan Lee',
            'email' => 'candidate2@test.com',
            'mobile_no' => '+44 7700 900202',
            'password' => Hash::make('password'),
            'role' => 'candidate',
            'is_active' => true,
        ]);

        $candidate3 = User::create([
            'name' => 'Sam Patel',
            'email' => 'candidate3@test.com',
            'mobile_no' => '+44 7700 900203',
            'password' => Hash::make('password'),
            'role' => 'candidate',
            'is_active' => true,
        ]);

        // 🔹 Jobs for company 1
        $jobLaravel = Job::create([
            'company_id' => $company1->id,
            'title' => 'Senior Laravel Developer',
            'description' => 'Build scalable backend systems with Laravel, queues, and PostgreSQL.',
            'location' => 'Remote',
            'salary' => '£70,000 – £85,000',
            'is_published' => true,
        ]);

        $jobReact = Job::create([
            'company_id' => $company1->id,
            'title' => 'Frontend Engineer (React)',
            'description' => 'Work on modern UI applications with React, TypeScript, and Tailwind.',
            'location' => 'London',
            'salary' => null,
            'is_published' => false,
        ]);

        $jobDevops = Job::create([
            'company_id' => $company1->id,
            'title' => 'DevOps Engineer',
            'description' => 'Own CI/CD, Kubernetes clusters, and observability for production services.',
            'location' => 'Hybrid — Manchester',
            'salary' => '£65,000 – £80,000',
            'is_published' => true,
        ]);

        $jobDesigner = Job::create([
            'company_id' => $company1->id,
            'title' => 'Product Designer',
            'description' => 'End-to-end product design, user research, and design systems.',
            'location' => 'Remote (EU)',
            'salary' => '€65,000 – €78,000',
            'is_published' => true,
        ]);

        $jobData = Job::create([
            'company_id' => $company1->id,
            'title' => 'Data Analyst',
            'description' => 'SQL, dashboards, and partnering with product on metrics and experiments.',
            'location' => 'Edinburgh',
            'salary' => '£42,000 – £52,000',
            'is_published' => false,
        ]);

        $jobPm = Job::create([
            'company_id' => $company1->id,
            'title' => 'Technical Product Manager',
            'description' => 'Roadmaps, stakeholder alignment, and delivery with engineering squads.',
            'location' => 'London',
            'salary' => '£75,000 – £95,000',
            'is_published' => true,
        ]);

        // 🔹 Jobs for company 2 (inactive company)
        $jobJunior = Job::create([
            'company_id' => $company2->id,
            'title' => 'Junior Developer',
            'description' => 'Entry-level full-stack role with mentorship.',
            'location' => 'Remote',
            'salary' => '£32,000 – £38,000',
            'is_published' => false,
        ]);

        Job::create([
            'company_id' => $company2->id,
            'title' => 'Marketing Intern',
            'description' => 'Support campaigns, content, and analytics for a small team.',
            'location' => 'Berlin',
            'salary' => '€2,000 / month',
            'is_published' => true,
        ]);

        // 🔹 Applications
        Application::create([
            'job_id' => $jobLaravel->id,
            'candidate_id' => $candidate1->id,
            'cover_letter' => 'Five years with PHP/Laravel; excited about your platform and API-first approach.',
            'cv_path' => null,
        ]);

        Application::create([
            'job_id' => $jobLaravel->id,
            'candidate_id' => $candidate2->id,
            'cover_letter' => 'Backend-focused engineer transitioning from Node; keen to deepen Laravel experience.',
            'cv_path' => null,
        ]);

        Application::create([
            'job_id' => $jobDevops->id,
            'candidate_id' => $candidate2->id,
            'cover_letter' => 'Strong AWS and Terraform background; comfortable on-call and improving SLOs.',
            'cv_path' => null,
        ]);

        Application::create([
            'job_id' => $jobReact->id,
            'candidate_id' => $candidate3->id,
            'cover_letter' => 'React/TS for three years; portfolio includes design-system work.',
            'cv_path' => null,
        ]);

        Application::create([
            'job_id' => $jobDesigner->id,
            'candidate_id' => $candidate3->id,
            'cover_letter' => 'Product designer with B2B SaaS experience; Figma and research-heavy process.',
            'cv_path' => null,
        ]);

        Application::create([
            'job_id' => $jobJunior->id,
            'candidate_id' => $candidate1->id,
            'cover_letter' => 'Recent bootcamp graduate looking for first commercial role with mentorship.',
            'cv_path' => null,
        ]);
    }
}
