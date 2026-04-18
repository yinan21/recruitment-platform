<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\Hash;

class AdminTestSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 🔹 Active Company
        $companyUser1 = User::create([
            'name' => 'Tech Corp User',
            'email' => 'company1@test.com',
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
            'password' => Hash::make('password'),
            'role' => 'company',
            'is_active' => false,
        ]);

        $company2 = Company::create([
            'user_id' => $companyUser2->id,
            'name' => 'Startup Inc',
        ]);

        // 🔹 Jobs for company 1
        Job::create([
            'company_id' => $company1->id,
            'title' => 'Senior Laravel Developer',
            'description' => 'Build scalable backend systems.',
            'location' => 'Remote',
            'is_published' => true,
        ]);

        Job::create([
            'company_id' => $company1->id,
            'title' => 'Frontend Engineer (React)',
            'description' => 'Work on modern UI applications.',
            'location' => 'London',
            'is_published' => false,
        ]);

        // 🔹 Jobs for company 2 (inactive company)
        Job::create([
            'company_id' => $company2->id,
            'title' => 'Junior Developer',
            'description' => 'Entry-level role.',
            'location' => 'Remote',
            'is_published' => false,
        ]);
    }
}
