<div>
    <div class="mb-4">
        <h1>Create New Company</h1>
        <p class="text-muted">Add a new company to the platform.</p>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="create">
        <div class="mb-3">
            <label for="name" class="form-label">Company Name</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" class="form-control @error('description') is-invalid @enderror" wire:model.defer="description" rows="5"></textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input id="website" type="url" class="form-control @error('website') is-invalid @enderror" wire:model.defer="website">
            @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Company</button>
        <a href="{{ route('admin.companies') }}" class="btn btn-secondary ms-2">Back to companies</a>
    </form>
</div>