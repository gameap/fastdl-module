@php
/**
 * @var \GameapModules\Fastdl\Models\FastdlServer[] $accounts
 * @var int $dsId
**/
@endphp

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
        {{ Form::open(['method' => 'PATCH', 'url' => route('admin.fastdl.accounts.sync',  $dsId), 'style'=>'display:inline']) }}
            {{ Form::button( '<i class="fas fa-sync"></i>&nbsp;' . __('fastdl::fastdl.sync'),
            [
                'class' => 'btn btn-dark',
                'v-on:click' => 'confirmAction($event, \'' . __('fastdl::fastdl.d_run_sync') . '\')',
                'type' => 'submit'
            ]
            ) }}
        {{ Form::close() }}

        <a class='btn btn-success' href="{{ route('admin.fastdl.accounts.create', $dsId) }}">
            <i class="fa fa-plus-square"></i>&nbsp;{{ __('main.create') }}
        </a>

        <a class='btn btn-warning' href="{{ route('admin.fastdl.accounts.last_error', $dsId) }}">
            <i class="fas fa-exclamation-triangle"></i>&nbsp;{{ __('fastdl::fastdl.last_error') }}
        </a>
    </div>

    @include('components.grid', [
        'modelsList' => $accounts,
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
