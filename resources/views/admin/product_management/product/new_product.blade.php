@extends('admin.layout.base')
@section('content')
    @push('css')
        <style>
            .custom-file-upload {
                border: 2px dashed #ccc;
                padding: 20px;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
                position: relative;
                display: inline-block;
                width: 100%;
                text-align: center;
            }

            .custom-file-upload:hover {
                border-color: #007bff;
                background: rgba(0, 123, 255, 0.1);
            }

            .custom-file-input {
                position: absolute;
                width: 100%;
                height: 100%;
                opacity: 0;
                cursor: pointer;
            }

            .custom-file-label {
                font-size: 16px;
                color: #555;
            }

            .custom-file-upload.dragover {
                border-color: #007bff;
                background: rgba(0, 123, 255, 0.1);
            }
        </style>

    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="newPost" method="post" action="{{ route('admin.product.create.process') }}"
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
                        <button type="submit" class="btn btn-primary submit">Publish product</button>
                    </div>
                </div>

                <div class="row">
                    <!-- First column-->
                    <div class="col-12 col-lg-8">
                        <!-- Product Information -->
                        <div class="card mb-6">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Product information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-6">
                                    <label class="form-label" for="ecommerce-product-name">Name<sup class="text-danger">*</sup></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="ecommerce-product-name"
                                        placeholder="Product title"
                                        name="productTitle"
                                        aria-label="Product title" />
                                </div>
                                <div class="row mb-6">
                                    <div class="col">
                                        <label class="form-label" for="ecommerce-product-sku">SKU</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="ecommerce-product-sku"
                                            placeholder="SKU"
                                            name="productSku"
                                            aria-label="Product SKU" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="ecommerce-product-barcode">Barcode</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="ecommerce-product-barcode"
                                            placeholder="0123-4567"
                                            name="productBarcode"
                                            aria-label="Product barcode" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="ecommerce-product-barcode">Brand</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="ecommerce-product-barcode"
                                            placeholder="Sunking"
                                            name="brand"
                                            aria-label="Product barcode" />
                                    </div>
                                </div>
                                <!-- Description -->
                                <div class="mb-6">
                                    <label class="form-label" >Short Description<sup class="text-danger">*</sup></label>
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        placeholder="Product Short Description"
                                        name="shortDescription"
                                        aria-label="Post title"></textarea>
                                </div>
                                <!-- Description -->
                                <div class="mb-6">
                                    <label class="form-label" >Full Description<sup class="text-danger">*</sup></label>
                                    <textarea
                                        type="text"
                                        class="form-control editor"
                                        placeholder="Product Full Description"
                                        name="description"
                                        aria-label="Post title"></textarea>
                                </div>
                                <!-- Description -->
                                <div class="mb-6">
                                    <label class="form-label" >Product Specifications<sup class="text-danger">*</sup></label>
                                    <textarea
                                        type="text"
                                        class="form-control editor"
                                        placeholder="Product Full Specifications"
                                        name="specifications"
                                        aria-label="Post title"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Information -->
                        <!-- Media -->
                        <div class="card mb-6">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 card-title">Product Images<sup class="text-danger">*</sup> </h5>
                            </div>
                            <div class="card-body">
                               <input class="form-control" name="photos[]" type="file" multiple accept="image/*"/>
                            </div>
                        </div>
                        <!-- /Media -->

                        <!-- Inventory -->
                        <div class="card mb-6">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Inventory</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Navigation -->
                                    <div class="col-12 col-md-4 col-xl-5 col-xxl-4 mx-auto card-separator">
                                        <div class="d-flex justify-content-between flex-column mb-4 mb-md-0 pe-md-4">
                                            <div class="nav-align-left">
                                                <ul class="nav nav-pills flex-column w-100">
                                                    <li class="nav-item">
                                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#restock" type="button">
                                                            <i class="ti ti-box ti-sm me-1_5"></i>
                                                            <span class="align-middle">Stock</span>
                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping"
                                                        type="button">
                                                            <i class="ti ti-car ti-sm me-1_5"></i>
                                                            <span class="align-middle">Pricing</span>
                                                        </button>
                                                    </li>

                                                    <li class="nav-item">
                                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#attributes"
                                                        type="button">
                                                            <i class="ti ti-link ti-sm me-1_5"></i>
                                                            <span class="align-middle">Attributes</span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Navigation -->
                                    <!-- Options -->
                                    <div class="col-12 col-md-8 col-xl-7 col-xxl-8 pt-6 pt-md-0">
                                        <div class="tab-content p-0 ps-md-4">
                                            <!-- Restock Tab -->
                                            <div class="tab-pane fade show active" id="restock" role="tabpanel">
                                                <h6 class="text-body">Stock</h6>
                                                <label class="form-label" for="ecommerce-product-stock">Product Quantity</label>
                                                <div class="row mb-4 g-4 pe-md-4">
                                                    <div class="col-12 col-sm-12">
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            id="ecommerce-product-stock"
                                                            placeholder="Quantity"
                                                            name="quantity"
                                                            aria-label="Quantity" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-check ms-2 mt-2 mb-4">
                                                            <input class="form-check-input" type="checkbox" value="1" id="price-charge-tax" checked name="trackInventory" />
                                                            <label class="switch-label" for="price-charge-tax"> Track Inventory  </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <!-- Instock switch -->
                                                        <div class="mb-6">
                                                            <label class="form-label" for="ecommerce-product-discount-price">
                                                                Low Stock Threshold <i class="fa fa-info-circle" data-bs-toggle="tooltip" title="This is the quantity which when gthe quantity of the
                                        product is less than, you will be notified about it."></i>
                                                            </label>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                id="ecommerce-product-discount-price"
                                                                placeholder="Alert Quantity"
                                                                name="low_stock_threshold"
                                                                aria-label="Quantity to alert" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Shipping Tab -->
                                            <div class="tab-pane fade" id="shipping" role="tabpanel">
                                                <h6 class="mb-3 text-body">Pricing</h6>
                                                <div>
                                                    <!-- Base Price -->
                                                    <div class="mb-6">
                                                        <label class="form-label" for="ecommerce-product-price">
                                                            Base Price<sup class="text-danger">*</sup>
                                                            <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                                               title="Slashed price which the buyers will see and compare to the selling price. Should always be
                                           greater than the Discounted price."></i>
                                                        </label>
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            step="0.01"
                                                            id="ecommerce-product-price"
                                                            placeholder="Price"
                                                            name="productPrice"
                                                            aria-label="Product price" />
                                                    </div>
                                                    <!-- Discounted Price -->
                                                    <div class="mb-6">
                                                        <label class="form-label" for="ecommerce-product-discount-price">
                                                            Discounted Price<sup class="text-danger">*</sup>
                                                            <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                                                                title="The actual price the product will be sold for on your storefront."></i>
                                                        </label>
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            step="0.01"
                                                            id="ecommerce-product-discount-price"
                                                            placeholder="Discounted Price"
                                                            name="productDiscountedPrice"
                                                            aria-label="Product discounted price" />
                                                    </div>
                                                    <!-- Charge tax check box -->
                                                </div>
                                            </div>
                                            <!-- Attributes Tab -->
                                            <div class="tab-pane fade" id="attributes" role="tabpanel">
                                                <h6 class="mb-2 text-body">Attributes</h6>
                                                <div>
                                                    <!-- Base Price -->
                                                    <div class="mb-6">
                                                        <label class="form-label" for="ecommerce-product-price">
                                                            Weight
                                                        </label>
                                                        <div class="input-group">
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                step="0.01"
                                                                id="ecommerce-product-price"
                                                                placeholder="Weight"
                                                                name="weight"
                                                                aria-label="Product price" />
                                                        </div>
                                                    </div>
                                                    <!-- Base Price -->
                                                    <div class="mb-6">
                                                        <label class="form-label" for="ecommerce-product-price">
                                                            Dimension Label
                                                        </label>
                                                        <div class="input-group">
                                                            <select name="dimension" class="form-select" required>
                                                                <option value="">-- Select Dimension --</option>
                                                                @foreach (\App\Enums\Dimension::cases() as $dimension)
                                                                    <option value="{{ $dimension->value }}">
                                                                        {{ $dimension->abbreviation() }} — {{ ucfirst($dimension->description()) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="mb-6">
                                                        <label class="form-label" for="ecommerce-product-price">
                                                            Height
                                                        </label>
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            step="0.01"
                                                            id="ecommerce-product-price"
                                                            placeholder="Height"
                                                            name="height"
                                                            aria-label="Product price" />
                                                    </div>
                                                    <div class="mb-6">
                                                        <label class="form-label" for="ecommerce-product-price">
                                                            Width
                                                        </label>
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            step="0.01"
                                                            id="ecommerce-product-price"
                                                            placeholder="Width"
                                                            name="width"
                                                            aria-label="Product price" />
                                                    </div>
                                                    <div class="mb-6">
                                                        <label class="form-label" for="ecommerce-product-price">
                                                            Length
                                                        </label>
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            step="0.01"
                                                            id="ecommerce-product-price"
                                                            placeholder="Length"
                                                            name="length"
                                                            aria-label="Product price" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Attributes Tab -->
                                        </div>
                                    </div>
                                    <!-- /Options-->
                                </div>
                            </div>
                        </div>
                        <!-- /Inventory -->
                    </div>
                    <!-- /Second column -->

                    <!-- Second column -->
                    <div class="col-12 col-lg-4">
                        <!-- Media -->
                        <div class="card mb-6">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 card-title">Featured Image<sup class="text-danger">*</sup></h5>
                            </div>
                            <div class="card-body">
                                <!-- Custom File Input -->
                                <div class="custom-file-upload text-center">
                                    <input type="file" id="featuredImage" class="custom-file-input"
                                           accept="image/png, image/jpeg, image/jpg, image/webp, image/avif, image/gif"
                                           name="featuredImage"/
                                    <label for="featuredImage" class="custom-file-label">
                                        Click to upload or drag & drop an image here
                                    </label>
                                    <small class="text-muted d-block mt-2">Allowed formats: jpg, jpeg, png, webp, avif, gif.</small>
                                </div>

                                <!-- Image Preview (Hidden by Default) -->
                                <div id="imagePreviewContainer" class="text-center mt-3" style="display: none;">
                                    <img id="imagePreview" src="" alt="Preview"
                                         class="img-fluid rounded shadow"
                                         style="max-width: 250px; display: block; margin: auto;">
                                </div>
                            </div>
                        </div>
                        <!-- /Media -->
                        <!-- Organize Card -->
                        <div class="card mb-6">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Organize</h5>
                            </div>
                            <div class="card-body">
                                <!-- Category -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-6 col ecommerce-select2-dropdown">
                                        <label class="form-label mb-1" for="category-org">
                                            <span>Category<sup class="text-danger">*</sup></span>
                                        </label>
                                        <select id="category-org" class="select2 form-select" name="category_id" data-placeholder="Select Category">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Add Category Button -->
                                    <a href="#addCategoryModal" data-bs-toggle="modal" class="fw-medium btn btn-icon btn-label-primary ms-4"
                                       id="addCategoryBtn">
                                        <i class="ti ti-plus ti-md"></i>
                                    </a>
                                </div>

                                <!-- Status -->
                                <div class="mb-6 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="status-org">Status<sup class="text-danger">*</sup> </label>
                                    <select id="status-org" class="select2 form-select" data-placeholder="Published" name="status">
                                        <option value="">Select an option</option>
                                        <option value="active" selected>Active</option>
                                        <option value="draft">Draft</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <!-- Tags -->
                                <div>
                                    <label for="ecommerce-product-tags" class="form-label mb-1">Tags</label>
                                    <input
                                        id="ecommerce-product-tags"
                                        class="form-control"
                                        name="tags"
                                        value="Solar, Energy, Renewable"
                                        aria-label="Product Tags" />
                                </div>
                            </div>
                        </div>
                        <!-- /Organize Card -->
                    </div>
                    <!-- /Second column -->
                </div>
            </div>
        </form>

    </div>
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategory" action="{{ route('admin.category.create.process') }}" method="post">
                        <label for="newCategoryName" class="form-label">Category Name</label>
                        <input type="text" id="newCategoryName" class="form-control" placeholder="Enter category name"
                               name="name">
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-primary saveCategory" id="saveCategoryBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ asset('dashboard/requests/admin/add_category.js') }}"></script>
        <script src="{{ asset('dashboard/requests/admin/publish_post.js') }}"></script>
        <script>
            $(document).ready(function () {
                let fileInput = $("#featuredImage");
                let fileLabel = $(".custom-file-label");
                let previewContainer = $("#imagePreviewContainer");
                let previewImage = $("#imagePreview");

                fileInput.change(function () {
                    let input = this;
                    let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/avif', 'image/gif'];

                    if (input.files && input.files[0]) {
                        let file = input.files[0];

                        // Validate file type
                        if (!allowedTypes.includes(file.type)) {
                            alert("Invalid file type. Please upload an image (jpg, jpeg, png, webp, avif, gif).");
                            input.value = ""; // Reset file input
                            previewContainer.hide(); // Hide preview
                            return;
                        }

                        let reader = new FileReader();
                        reader.onload = function (e) {
                            previewImage.attr("src", e.target.result);
                            previewContainer.fadeIn(); // Show preview with fade-in effect
                        };
                        reader.readAsDataURL(file);

                        // Update label text
                        fileLabel.text(file.name);
                    } else {
                        previewContainer.hide(); // Hide preview if no file selected
                        fileLabel.text("Click to upload or drag & drop an image here");
                    }
                });

                // Drag and Drop Functionality
                $(".custom-file-upload").on("dragover", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).addClass("dragover");
                });

                $(".custom-file-upload").on("dragleave", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass("dragover");
                });

                $(".custom-file-upload").on("drop", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass("dragover");

                    let files = e.originalEvent.dataTransfer.files;
                    if (files.length > 0) {
                        fileInput.prop("files", files).trigger("change");
                    }
                });
            });

            $(document).ready(function () {
                $("#is-sponsored").change(function () {
                    if ($(this).is(":checked")) {
                        $("#sponsored-fields").fadeIn();
                    } else {
                        $("#sponsored-fields").fadeOut();
                        // Clear input values when hidden
                        $("#sponsor-name, #sponsor-email, #sponsored-price, #sponsored-expiry").val("");
                        $("#sponsored-status").val("pending");
                    }
                });
            });
        </script>


        <script>
            //Javascript to handle the post adding

            (function () {
                // Basic Tags

                const tagifyBasicEl = document.querySelector('#ecommerce-product-tags');
                const TagifyBasic = new Tagify(tagifyBasicEl);

                // Datepicker
                const date = new Date();

                const productDate = document.querySelector('.product-date');

                if (productDate) {
                    productDate.flatpickr({
                        monthSelectorType: 'static',
                        defaultDate: date
                    });
                }
            })();

            //Jquery to handle the e-commerce product add page

            $(function () {
                // Select2
                var select2 = $('.select2');
                if (select2.length) {
                    select2.each(function () {
                        var $this = $(this);
                        $this.wrap('<div class="position-relative"></div>').select2({
                            dropdownParent: $this.parent(),
                            placeholder: $this.data('placeholder') // for dynamic placeholder
                        });
                    });
                }

                var formRepeater = $('.form-repeater');

                // Form Repeater
                // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
                // -----------------------------------------------------------------------------------------------------------------

                if (formRepeater.length) {
                    var row = 2;
                    var col = 1;
                    formRepeater.on('submit', function (e) {
                        e.preventDefault();
                    });
                    formRepeater.repeater({
                        show: function () {
                            var fromControl = $(this).find('.form-control, .form-select');
                            var formLabel = $(this).find('.form-label');

                            fromControl.each(function (i) {
                                var id = 'form-repeater-' + row + '-' + col;
                                $(fromControl[i]).attr('id', id);
                                $(formLabel[i]).attr('for', id);
                                col++;
                            });

                            row++;
                            $(this).slideDown();
                            $('.select2-container').remove();
                            $('.select2.form-select').select2({
                                placeholder: 'Placeholder text'
                            });
                            $('.select2-container').css('width', '100%');
                            $('.form-repeater:first .form-select').select2({
                                dropdownParent: $(this).parent(),
                                placeholder: 'Placeholder text'
                            });
                            $('.position-relative .select2').each(function () {
                                $(this).select2({
                                    dropdownParent: $(this).closest('.position-relative')
                                });
                            });
                        }
                    });
                }
            });
        </script>
        <script src="{{ asset('dashboard/requests/repeater.js') }}"></script>
    @endpush
@endsection
