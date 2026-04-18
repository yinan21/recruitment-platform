<div>
    <h3>Edit: {{ $job->title }}</h3>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TITLE --}}
    <div class="mb-3">
        <label>Job Title</label>
        <input type="text"
               wire:model.live="title"
               class="form-control">

        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- DESCRIPTION --}}
    <div class="mb-3">
        <label>Description</label>
        <textarea wire:model.live="description"
                  class="form-control"
                  rows="5"></textarea>

        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- LOCATION --}}
    <div class="mb-3">
        <label>Location</label>
        <input type="text"
               wire:model.live="location"
               class="form-control">
    </div>

    {{-- PUBLISH --}}
    <div class="form-check mb-3">
        <input type="checkbox"
               wire:model="is_published"
               class="form-check-input">

        <label class="form-check-label">Published</label>
    </div>

    <button wire:click="update"
            wire:loading.attr="disabled"
            class="btn btn-primary">
        Save Changes
    </button>

    <a href="{{ route('admin.jobs') }}" class="btn btn-secondary">
        Back
    </a>

    <div wire:loading>Saving...</div>
</div>