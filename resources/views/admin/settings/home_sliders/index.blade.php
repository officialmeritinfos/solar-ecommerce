@extends('admin.layout.base')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Product List Table -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0">
                    <a href="{{ route('admin.settings.home-sliders.new') }}" class="btn btn-primary">New Slider</a>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-products table">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>Photo</th>
                            <th>Title</th>
                            <th>Background-Text</th>
                            <th>Description</th>
                            <th>Link</th>
                            <th>Link Text</th>
                            <th>Status</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sliders as $slider)
                            <tr>
                                <td></td>
                                <td>
                                    <img src="{{ asset($slider->photo) }}" width="50" />
                                </td>
                                <td>{{ $slider->title }}</td>
                                <td>{{ $slider->background_text }}</td>
                                <td>{{ $slider->description }}</td>
                                <td>{{ $slider->link_url }}</td>
                                <td>{{ $slider->link_text }}</td>
                                <td>
                                    @if($slider->active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.settings.home-sliders.edit', $slider->id) }}" class="text-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.settings.home-sliders.delete', $slider->id) }}" class="text-danger">
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

    </div>
@endsection
