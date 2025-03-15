@extends('admin.layout.base')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <livewire:admin.affiliates.details :affiliate="$affiliate" lazy/>

    </div>

@endsection
