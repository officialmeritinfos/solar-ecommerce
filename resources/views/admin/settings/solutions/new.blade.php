@extends('admin.layout.base')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="newPost" method="post" action="{{ route('admin.settings.solutions.new.process') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="app-ecommerce">
                <!-- Add Product -->
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                    <div class="d-flex flex-column justify-content-center">
                        <h4 class="mb-1">{{ $pageName }}</h4>
                    </div>
                    <div class="d-flex align-content-center flex-wrap gap-4">
                        <div class="d-flex gap-4">
                            <a href="{{ url()->previous() }}" class="btn btn-label-secondary">Discard</a>
                        </div>
                        <button type="submit" class="btn btn-primary submit">Publish Solution</button>
                    </div>
                </div>

                <div class="row">
                    <!-- First column-->
                    <div class="col-12 col-lg-12">
                        <!-- Product Information -->
                        <div class="card mb-6">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-6">
                                    <label class="form-label" for="ecommerce-product-name">Title<sup class="text-danger">*</sup></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="ecommerce-product-name"
                                        placeholder=" title"
                                        name="title"
                                        aria-label="Product title" />
                                </div>

                                <!-- Description -->
                                <div class="mb-6">
                                    <label class="form-label" > Content<sup class="text-danger">*</sup></label>
                                    <textarea
                                        type="text"
                                        class="form-control summernote"
                                        placeholder=" Description"
                                        name="contents"
                                        aria-label="Post title"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Information -->
                        <!-- Media -->
                        <div class="card mb-6">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 card-title"> Image<sup class="text-danger">*</sup> </h5>
                            </div>
                            <div class="card-body">
                                <input class="form-control" name="photo" type="file" accept="image/*"/>
                            </div>
                        </div>
                        <!-- /Media -->

                    </div>
                </div>
            </div>
        </form>


    </div>
    @push('js')
        <script src="{{ asset('dashboard/requests/admin/publish_post.js') }}"></script>
    @endpush
@endsection
