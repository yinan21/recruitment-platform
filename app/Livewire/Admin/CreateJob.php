<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Job;
use App\Models\Company;

class CreateJob extends Component
{
    public $title;
    public $description;
    public $location;
    public $company_id;
    public $is_published = false;

    public function create()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

        Job::create([
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'company_id' => $this->company_id,
            'is_published' => $this->is_published,
        ]);

        session()->flash('success', 'Job created successfully.');

        return redirect()->route('admin.jobs');
    }

    public function render()
    {
        $companies = Company::all();

        return view('livewire.admin.create-job', [
            'companies' => $companies
        ]);
    }
}