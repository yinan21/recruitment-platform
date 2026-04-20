<?php

namespace App\Livewire\Admin;

use App\Models\Job;
use Livewire\Component;
use Livewire\WithPagination;

class PendingCompanyJobsQueue extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function approve(int $id): void
    {
        $job = Job::query()->pendingEmployerOwned()->findOrFail($id);
        $job->update(['is_published' => true]);
    }

    public function render()
    {
        $jobs = Job::query()
            ->pendingEmployerOwned()
            ->with('company.user')
            ->withCount('applications')
            ->when(trim($this->search) !== '', function ($q) {
                $term = '%'.addcslashes($this->search, '%_\\').'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('title', 'like', $term)
                        ->orWhere('salary', 'like', $term)
                        ->orWhereHas('company', fn ($c) => $c->where('name', 'like', $term));
                });
            })
            ->latest('id')
            ->paginate(15);

        return view('livewire.admin.pending-company-jobs-queue', [
            'jobs' => $jobs,
        ]);
    }
}
