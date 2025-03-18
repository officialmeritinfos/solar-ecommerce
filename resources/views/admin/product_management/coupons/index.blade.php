@extends('admin.layout.base')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <livewire:admin.coupons.lists  lazy/>

    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Delegated event for Livewire compatibility
                $(document).on('click', '.copy-btn', function () {
                    const code = $(this).data('code');

                    navigator.clipboard.writeText(code).then(() => {
                        Swal.fire({
                            text: `Copied: ${code}`,
                            icon: 'success',
                            toast: true,
                            timer: 2000,
                            position: 'top-end',
                            showConfirmButton: false,
                        });
                    }).catch(() => {
                        Swal.fire({
                            text: 'Failed to copy coupon code.',
                            icon: 'error',
                            toast: true,
                            timer: 2000,
                            position: 'top-end',
                            showConfirmButton: false,
                        });
                    });
                });
            });
        </script>

    @endpush
@endsection
