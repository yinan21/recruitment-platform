<div>
    <h1>Company Management</h1>

    <input type="text" wire:model.live="search" placeholder="Search companies..." class="form-control mb-3">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Website</th>
                <th>Jobs Count</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($companies as $company)
                <tr>
                    {{-- COMPANY NAME (link to edit) --}}
                    <td>
                        <a href="{{ route('admin.companies.edit', $company->id) }}">
                            {{ $company->name }}
                        </a>
                    </td>

                    {{-- DESCRIPTION --}}
                    <td>
                        {{ Str::limit($company->description, 50) }}
                    </td>

                    {{-- WEBSITE --}}
                    <td>
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank">
                                {{ $company->website }}
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    {{-- JOBS COUNT --}}
                    <td>
                        {{ $company->jobs_count }}
                    </td>

                    <td>
                        <a href="{{ route('admin.companies.edit', $company->id) }}"
                           class="btn btn-primary btn-sm">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $companies->links() }}
</div>