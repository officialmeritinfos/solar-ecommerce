<div>
    <div class="container py-4">


        {{-- Success Message --}}
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search and Add Button --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="Search FAQs...">
            </div>
            <div class="col-md-6 text-end">
                <button wire:click="create" class="btn btn-primary">
                    <span wire:loading.remove> Add FAQ</span>
                    <span wire:loading>Please wait...</span>
                </button>
            </div>
        </div>

        {{-- Add FAQ Form --}}
        @if ($showAddForm)
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Add New FAQ</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" wire:model.defer="question" class="form-control">
                        @error('question') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea wire:model.defer="answer" class="form-control" rows="4"></textarea>
                        @error('answer') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button wire:click="store" class="btn btn-success me-2">
                            <span wire:loading.remove><i class="bi bi-save"></i> Save</span>
                            <span wire:loading>Please wait...</span>
                        </button>
                        <button wire:click="cancel" class="btn btn-secondary">
                            <span wire:loading.remove> Cancel</span>
                            <span wire:loading>Please wait...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Edit FAQ Form --}}
        @if ($showEditForm)
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <strong>Edit FAQ</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" wire:model.defer="question" class="form-control">
                        @error('question') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea wire:model.defer="answer" class="form-control" rows="4"></textarea>
                        @error('answer') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button wire:click="update" class="btn btn-warning me-2">
                            <span wire:loading.remove><i class="bi bi-check-circle"></i> Update</span>
                            <span wire:loading>Please wait...</span>
                        </button>
                        <button wire:click="cancel" class="btn btn-secondary">
                            <span wire:loading.remove> Cancel</span>
                            <span wire:loading>Please wait...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- FAQ Table --}}
        <div class="card">
            <div class="card-header">
                <strong>FAQs</strong>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($faqs as $index => $faq)
                        <tr>
                            <td>{{ $faqs->firstItem() + $index }}</td>
                            <td>{{ $faq->questions }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($faq->answers, 100) }}</td>
                            <td>
                                <button wire:click="edit({{ $faq->id }})" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </button>
                                {{-- Optional: delete --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No FAQs found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if ($faqs->hasPages())
                <div class="card-footer">
                    {{ $faqs->links() }}
                </div>
            @endif
        </div>

    </div>

</div>
