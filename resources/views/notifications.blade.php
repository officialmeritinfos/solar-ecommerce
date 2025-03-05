<script>
    @if(session('success'))
        Swal.fire({
            text: "{{ session('success') }}",
            icon: 'success',
            customClass: {
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false,
            position: "top-end"
        });
    @endif

    @if($message = session('error'))
        Swal.fire({
            text: "{{ session('error') }}",
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false,
            position: "top-end"
        });
    @endif

    @if($message = session('info'))
        Swal.fire({
            text: "{{ session('info') }}",
            icon: 'info',
            customClass: {
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false,
            position: "top-end"
        });
    @endif

    @if($message = session('warning'))
        Swal.fire({
            text: "{{ session('warning') }}",
            icon: 'warning',
            customClass: {
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false,
            position: "top-end"
        });
    @endif

    @if($message = session('errors'))
        Swal.fire({
            text: "{{ session('errors') }}",
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false,
            position: "top-end"
        });
    @endif
</script>
