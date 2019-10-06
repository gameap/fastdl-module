@php($title = "FastDL Accounts")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.fastdl') }}">FastDL</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.fastdl.accounts', $fastdlDs->ds_id) }}">Accounts</a></li>
        <li class="breadcrumb-item active">Create new account</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.fastdl.accounts.store', $fastdlDs->ds_id)]) !!}
        <div class="row mt-2 mb-2">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group" id="serversForm">
                            {{ Form::label('servers', 'Servers', ['class' => 'control-label']) }}
                            {{ Form::select('server_id',
                                $gameServers->map(function($server) {
                                    $server->label = "{$server->name}&nbsp;&nbsp;&nbsp;&nbsp;{$server->game_name}&nbsp;&nbsp;&nbsp;&nbsp;{$server->server_ip}:{$server->server_port}";
                                    return $server;
                                })->pluck('label', 'id'), null, ['class' => 'form-control']) }}
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection