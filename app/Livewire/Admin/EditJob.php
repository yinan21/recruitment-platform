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
    public $is_published = false;

    public function mount(Job $job)
    {
        $this->job = $job;

        // preload values
        $this->title = $job->title;
        $this->description = $job->description;
        $this->location = $job->location;
        $this->is_published = $job->is_published;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
        ]);

        $this->job->update([
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'is_published' => $this->is_published,
        ]);

        session()->flash('success', 'Job updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.edit-job');
    }
}