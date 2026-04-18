<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Company;

class CreateCompany extends Component
{
    public $name;
    public $description;
    public $website;

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        Company::create([
            'name' => $this->name,
            'description' => $this->description,
            'website' => $this->website,
            'user_id' => auth()->id(), // assuming the creator is the user
        ]);

        session()->flash('success', 'Company created successfully.');

        return redirect()->route('admin.companies');
    }

    public function render()
    {
        return view('livewire.admin.create-company');
    }
}