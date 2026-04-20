<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Job;

class EditJob extends Component
{
    public Job $job;

    public $title;
    public $description;
    public $location;
    public $salary;
    public $is_published = false;

    public function mount(Job $job)
    {
        $this->job = $job;

        // preload values
        $this->title = $job->title;
        $this->description = $job->description;
        $this->location = $job->location;
        $this->salary = $job->salary;
        $this->is_published = $job->is_published;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
        ]);

        $this->job->update([
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'salary' => filled($this->salary) ? trim($this->salary) : null,
            'is_published' => $this->is_published,
        ]);

        session()->flash('success', 'Job updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.edit-job');
    }
}