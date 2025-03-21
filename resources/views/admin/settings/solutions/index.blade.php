@extends('admin.layout.base')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Product List Table -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0">
                    <a href="{{ route('admin.settings.solutions.new') }}" class="btn btn-primary">New Use Case</a>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-products table">
                    <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Photo</th>
                        <th>Title</th>

                        <th>Status</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($solutions as $solution)
                        <tr>
                            <td></td>
                            <td>
                                <img src="{{ asset($solution->photo) }}" width="50" />
                            </td>
                            <td>{{ $solution->title }}</td>

                            <td>
                                @if($solution->status==1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.settings.solutions.edit', $solution->id) }}" class="text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a href="{{ route('admin.settings.solutions.delete', $solution->id) }}" class="text-danger">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->


@endsection
