<div>
    <div class="mb-4">
        <h1>Create New Job</h1>
        <p class="text-muted">Add a new job posting to the platform.</p>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="create">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" wire:model.defer="title">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" class="form-control @error('description') is-invalid @enderror" wire:model.defer="description" rows="5"></textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" wire:model.defer="location">
            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">Company</label>
            <select id="company_id" class="form-control @error('company_id') is-invalid @enderror" wire:model.defer="company_id">
                <option value="">Select a company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
            @error('company_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-check mb-4">
            <input id="is_published" type="checkbox" class="form-check-input" wire:model="is_published">
            <label for="is_published" class="form-check-label">Published</label>
        </div>

        <button type="submit" class="btn btn-primary">Create Job</button>
        <a href="{{ route('admin.jobs') }}" class="btn btn-secondary ms-2">Back to jobs</a>
    </form>
</div>