@extends('admin.layout.base')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Product Categories</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    Add New Category
                </button>
            </div>

            <table class="table table-bordered table-hover align-middle" id="categories-table">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Parent</th>
                    <th>Number of Product</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($categories as $category)
                    <tr data-id="{{ $category->id }}"
                        data-name="{{ $category->name }}"
                        data-slug="{{ $category->slug }}"
                        data-description="{{ $category->description }}"
                        data-image="{{ asset($category->image) }}"
                        data-image-path="{{ $category->image }}"
                        data-parent_id="{{ $category->parent_id }}"
                        data-is_active="{{ $category->is_active }}"
                        data-edit-url="{{ route('admin.category.edit.process',$category->id) }}"
                        data-delete-url="{{ route('admin.category.delete.process',$category->id) }}"
                    >
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($category->image)
                                <img src="{{ asset($category->image) }}" alt="Image" width="50">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->parent?->name ?? '—' }}</td>
                        <td>{{ $category->products->count() }}</td>
                        <td>
                        <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        </td>
                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-category-btn" title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-category-btn" title="Delete">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No categories found.</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
            <div class="mt-5">
                {{ $categories->links() }}
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form  id="addCategory" method="POST" action="{{ route('admin.category.create.process') }}" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select name="parent_id" id="parent_id" class="form-select">
                            <option value="">-- None --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>


                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked value="1">
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary saveCategory">Save Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editCategoryForm" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="category_id" id="edit_category_id">

                    <div class="mb-3">
                        <label for="edit_parent_id" class="form-label">Parent Category</label>
                        <select name="parent_id" id="edit_parent_id" class="form-select">
                            <option value="">-- None --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Category Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Change Image</label>
                        <input type="file" name="image" id="edit_image" class="form-control" accept="image/*">
                        <small id="current-image" class="d-block mt-2"></small>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active" value="1">
                        <label class="form-check-label" for="edit_is_active">Active</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success update-category-btn">Update Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteCategoryForm" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger confirm-delete-btn">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('dashboard/requests/admin/add_category.js') }}"></script>
        <script src="{{ asset('dashboard/requests/admin/edit_category.js') }}"></script>
        <script src="{{ asset('dashboard/requests/admin/delete_category.js') }}"></script>
        <script>
            $(document).ready(function () {
                // Delete Modal
                $(document).on('click', '.delete-category-btn', function () {
                    let row = $(this).closest('tr');
                    let deleteUrl = row.data('delete-url');
                    $('#deleteCategoryForm').attr('action', deleteUrl);
                    $('#deleteCategoryModal').modal('show');
                });

                // Edit Modal
                $(document).on('click', '.edit-category-btn', function () {
                    let row = $(this).closest('tr');

                    $('#editCategoryForm').attr('action', row.data('edit-url'));
                    $('#edit_category_id').val(row.data('id'));
                    $('#edit_name').val(row.data('name'));
                    $('#edit_description').val(row.data('description') || '');
                    $('#edit_parent_id').val(row.data('parent_id'));
                    $('#edit_is_active').prop('checked', row.data('is_active') === 1 || row.data('is_active') === '1');

                    // Show image preview
                    if (row.data('image-path')) {
                        $('#current-image').html(`<img src="${row.data('image')}" width="80" class="mt-1">`);
                    } else {
                        $('#current-image').html(`<small class="text-muted">No image</small>`);
                    }

                    $('#editCategoryModal').modal('show');
                });
            });
        </script>
    @endpush

@endsection
