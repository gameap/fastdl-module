@php($title = __('fastdl::fastdl.fastdl_ds_settings_title'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.fastdl') }}">FastDL</a></li>
        <li class="breadcrumb-item active">{{ __('fastdl::fastdl.ds_settings') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::model($fastdlDs, ['method' => 'PATCH', 'url' => route('admin.fastdl.save', ['id' => $dedicatedServer->getKey()])]) !!}
        <div class="row mt-2 mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('method', __('fastdl::fastdl.method'), ['class' => 'control-label']) }}

                            {{ Form::select(
                                'method',
                                [
                                    'link' => 'link',
                                    'mount' => 'mount',
                                    'copy' => 'copy',
                                    'rsync' => 'rsync'
                                ],
                                empty($fastdlDs->method) ? 'rsync' : $fastdlDs->method,
                                ['class' => 'form-control'])
                            }}
                        </div>

                        {{-- {{ Form::bsText('host', $dedicatedServer->ip[0] ?? '0.0.0.0') }} --}}

                        <div class="form-group">
                            {{ Form::label('host', __('fastdl::fastdl.host'), ['class' => 'control-label']) }}

                            {{ Form::select(
                                'host',
                                array_combine($dedicatedServer->ip, $dedicatedServer->ip),
                                null,
                                ['class' => 'form-control'])
                            }}
                        </div>

                        {{ Form::bsText('port', $fastdlDs->port ?? '80') }}

                        <div class="form-check">
                            {{ Form::checkbox('autoindex', 'on', true, ['id' => 'enabled', 'class' => 'form-check-input']) }}
                            {{ Form::label('autoindex', __('fastdl::fastdl.autoindex'), ['class' => 'form-check-label']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <input-many-list
                                name="options"
                                :initial-items="[]"
                                :labels="['{{ __('fastdl::fastdl.option_name') }}', '{{ __('fastdl::fastdl.option_value') }}']"
                                :keys="['option', 'value']"
                                :input-types="['text', 'text']">
                        </input-many-list>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="form-group">
                {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection