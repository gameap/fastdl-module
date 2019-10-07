@php($title = __('fastdl::fastdl.fastdl_accounts_title'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.fastdl') }}">FastDL</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.fastdl.accounts', $fastdlServer->ds_id) }}">{{ __('fastdl::fastdl.accounts') }}</a></li>
        <li class="breadcrumb-item active">Show</li>
    </ol>
@endsection

@section('content')
    Not Implemented
@endsection