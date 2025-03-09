@extends('admin.layout.base')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <livewire:admin.settings.delivery.sublocations :location="$location" lazy/>

    </div>
@endsection
