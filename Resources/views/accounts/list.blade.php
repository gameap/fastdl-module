@php($title = "FastDL Accounts")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.fastdl') }}">FastDL</a></li>
        <li class="breadcrumb-item active">Accounts</li>
    </ol>
@endsection

@section('content')
    <div class="mb-2">
        <a class='btn btn-success' href="{{ route('admin.fastdl.accounts.create', $fastdlDs->ds_id) }}">
            <span class="fa fa-plus-square"></span>&nbsp;{{ __('main.create') }}
        </a>
    </div>

    @include('components.grid', [
        'modelsList' => $fastdlDs->accounts,
        'labels' => [ 'Server Name', 'FastDL Address', 'Last Sync'],
        'attributes' => [
            'server.name',
            'address',
            'last_sync',
        ],
        // 'viewRoute' => 'admin.fastdl.accounts.show',
        'destroyRoute' => 'admin.fastdl.accounts.destroy',
    ])

@endsection