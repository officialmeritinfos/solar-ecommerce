<div>
    <!-- content -->
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center">
                        <a  data-lightbox="product-gallery" class="rounded-4"
                           href="{{ asset($product->featuredImage) }}">
                            <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit"
                                 src="{{ asset($product->featuredImage) }}" />
                        </a>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        @foreach($photos as $photo)
                            <a
                                data-lightbox="product-gallery"
                                href="{{ asset($photo->path) }}"
                                data-title="{{ $product->name }}"
                                class="border mx-1 rounded-2 item-thumb"
                            >
                                <img
                                    width="60"
                                    height="60"
                                    class="rounded-2"
                                    src="{{ asset($photo->path) }}"
                                    alt="Product Photo"
                                />
                            </a>
                        @endforeach
                    </div>
                    <!-- thumbs-wrap.// -->
                    <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            {{$product->name}}
                        </h4>
                        <div class="d-flex flex-row my-3">
                            <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>{{ $totalOrders }} orders</span>
                            @if($product->track_inventory)
                                @if($product->quantity ==0)
                                    <span class="text-danger ms-2">Out of Stock</span>
                                @elseif($product->low_stock_threshold >= $product->quantity)
                                    <span class="text-warning ms-2">Almost out of Stock</span>
                                @else
                                    <span class="text-success ms-2">In stock</span>
                                @endif
                            @elseif($product->quantity==0)
                                <span class="text-danger ms-2">Out of Stock</span>
                            @else
                                <span class="text-success ms-2">In stock</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <span class="h5"><del>{{ getCurrencySign() }}{{ number_format($product->price,2) }}</del> {{ getCurrencySign() }}{{ number_format($product->sale_price,2) }}</span>
                        </div>

                        <p>
                            {!! $product->description !!}
                        </p>

                        <div class="row">
                            <dt class="col-3">Quantity</dt>
                            <dd class="col-9">{{ $product->quantity }}</dd>

                            <dt class="col-3">SKU:</dt>
                            <dd class="col-9">{{ $product->sku??'N/A' }}</dd>

                            <dt class="col-3">Barcode</dt>
                            <dd class="col-9">{{ $product->barcode??'N/A' }}</dd>

                            <dt class="col-3">Brand</dt>
                            <dd class="col-9">{{ $product->brand }}</dd>
                        </div>

                        <hr />
                        <div class="row">
                            <h5>Dimensions</h5>
                            <dt class="col-3">Weight</dt>
                            <dd class="col-9">{{ $product->weight }} kg</dd>

                            <dt class="col-3">Width:</dt>
                            <dd class="col-9">{{ $product->width??'N/A' }} {{ $product->dimension }}</dd>

                            <dt class="col-3">Length</dt>
                            <dd class="col-9">{{ $product->length??'N/A' }} {{ $product->dimension }}</dd>

                            <dt class="col-3">Height</dt>
                            <dd class="col-9">{{ $product->height??'N/A' }} {{ $product->dimension }}</dd>
                        </div>

                        <hr />
                        <div class="row">
                            <h5>Dimensions</h5>
                            <dt class="col-12">{!! $product->specifications !!}</dt>
                        </div>
                        <hr />
                    </div>
                </main>
                <div class="col-lg-12 mb-4 mt-5">

                    <table class="table border mt-3 mb-2">
                        @foreach($photos as $photo)
                            <tr>
                                <th class="py-2">
                                    <img src="{{ asset($photo->path) }}" style="width: 150px;"/>
                                </th>
                                <td class="py-2">
                                    <button wire:click="deletePhoto({{ $photo->id }})" class="btn btn-danger">
                                        <span wire:loading.remove> <i class="fa fa-trash-alt"></i></span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->

    <section class="py-5">
        <!-- Orders Table -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Orders Containing This Product</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Order Ref</th>
                        <th>Buyer</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $key => $orderItem)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $orderItem->order->order_reference }}</td>
                            <td>{{ $orderItem->order->user->name ?? 'N/A' }}</td>
                            <td>{{ $orderItem->quantity }}</td>
                            <td> {{ getCurrencySign() }}{{ number_format($orderItem->total, 2) }}</td>
                            <td><span class="badge bg-{{ $orderItem->order->status === 'delivered' ? 'success' : 'warning' }}">
                            {{ ucfirst($orderItem->order->status) }}
                        </span></td>
                            <td>{{ $orderItem->created_at->format('d M, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.order.detail', $orderItem->order->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No orders found for this product.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </section>

</div>
