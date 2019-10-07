@php($title = __('fastdl::fastdl.fastdl_last_error_title'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.fastdl') }}">FastDL</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.fastdl.accounts', $fastdlDs->ds_id) }}">{{ __('fastdl::fastdl.accounts') }}</a></li>
        <li class="breadcrumb-item active">{{ __('fastdl::fastdl.last_error') }}</li>
    </ol>
@endsection

@section('content')
    @if (!empty($lastError))
        <pre class="console">{!! $lastError !!}</pre>
    @else
        <div class="alert alert-success">{{ __('fastdl::fastdl.no_last_errors') }}</div>
    @endif
@endsection