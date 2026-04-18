<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Job;

class JobsTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function approve($id)
    {
        Job::findOrFail($id)->update([
            'is_published' => true
        ]);
    }

    public function reject($id)
    {
        Job::findOrFail($id)->update([
            'is_published' => false
        ]);
    }

    public function render()
    {    
        $jobs = Job::query()
            ->with('company')
            ->withCount('applications')
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.jobs-table', [
            'jobs' => $jobs
        ]); 
    }
}
