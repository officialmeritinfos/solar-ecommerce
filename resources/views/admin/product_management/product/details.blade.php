@extends('admin.layout.base')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <livewire:admin.products.details :product="$product" lazy/>

    </div>

@endsection
