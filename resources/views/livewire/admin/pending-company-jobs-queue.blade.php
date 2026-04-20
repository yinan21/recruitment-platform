<div>
    <p class="text-muted">Jobs that are <strong>not published</strong> and belong to companies registered by employer accounts (role: company). Approve to publish on the public site.</p>

    <input type="text" wire:model.live="search" placeholder="Search by title, salary, or company…" class="form-control mb-3">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Company</th>
                <th>Employer</th>
                <th>Salary</th>
                <th>Applications</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
                <tr>
                    <td>
                        <a href="{{ route('admin.jobs.edit', $job->id) }}">{{ $job->title }}</a>
                    </td>
                    <td>
                        @if($job->company)
                            <a href="{{ route('admin.companies.edit', $job->company->id) }}">{{ $job->company->name }}</a>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($job->company?->user)
                            {{ $job->company->user->name }}<br>
                            <span class="small text-muted">{{ $job->company->user->email }}</span>
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $job->salary ?: '—' }}</td>
                    <td>
                        <a href="{{ route('admin.jobs.applications', $job) }}">{{ $job->applications_count }}</a>
                    </td>
                    <td>
                        <button type="button" wire:click="approve({{ $job->id }})" class="btn btn-success btn-sm">Publish</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No pending employer jobs.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $jobs->links() }}
</div>
