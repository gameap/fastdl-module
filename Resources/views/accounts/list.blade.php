@php($title = __('fastdl::fastdl.fastdl_accounts_title'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.fastdl') }}">FastDL</a></li>
        <li class="breadcrumb-item active">{{ __('fastdl::fastdl.accounts') }}</li>
    </ol>
@endsection

@section('content')
    <div class="mb-2">
        <a class='btn btn-success' href="{{ route('admin.fastdl.accounts.create', $fastdlDs->ds_id) }}">
            <i class="fa fa-plus-square"></i>&nbsp;{{ __('main.create') }}
        </a>

        <a class='btn btn-warning' href="{{ route('admin.fastdl.accounts.last_error', $fastdlDs->ds_id) }}">
            <i class="fas fa-exclamation-triangle"></i>&nbsp;{{ __('fastdl::fastdl.last_error') }}
        </a>
    </div>

    @include('components.grid', [
        'modelsList' => $fastdlDs->accounts,
        'labels' => [ __('fastdl::fastdl.server_name'), __('fastdl::fastdl.address'), __('fastdl::fastdl.last_sync')],
        'attributes' => [
            'server.name',
            'address',
            'last_sync',
        ],
        // 'viewRoute' => 'admin.fastdl.accounts.show',
        'destroyRoute' => 'admin.fastdl.accounts.destroy',
    ])

@endsection