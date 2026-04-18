<div>
    <h1>Job Management</h1>

    <input type="text" wire:model.live="search" placeholder="Search jobs..." class="form-control mb-3">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Company</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($jobs as $job)
                <tr>
                {{-- JOB TITLE (link to edit) --}}
                <td>
                    <a href="{{ route('admin.jobs.edit', $job->id) }}">
                        {{ $job->title }}
                    </a>
                </td>

                {{-- COMPANY (link to edit company) --}}
                <td>
                    @if($job->company)
                        <a href="{{ route('admin.companies.edit', $job->company->id) }}">
                            {{ $job->company->name }}
                        </a>
                    @else
                        -
                    @endif
                </td>

                    <td>
                        @if($job->is_published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>

                    <td>
                        <button wire:click="approve({{ $job->id }})"
                                class="btn btn-success btn-sm">
                            Approve
                        </button>

                        <button wire:click="reject({{ $job->id }})"
                                class="btn btn-danger btn-sm">
                            Reject
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $jobs->links() }}
</div>