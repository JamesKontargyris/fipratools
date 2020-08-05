@extends('layouts.master')

@section('page-header')
    Toolbox
@stop

@section('page-nav')
    @if($user->hasRole('Administrator'))
        <li><a href="{{ route('toolbox.create') }}" class="primary"><i class="fa fa-plus-circle"></i> Add a new resource</a></li>
    @endif
@stop

@section('content')

    @include('layouts.partials.messages')

    <p>A selection of useful Fipra-related resources.</p>

    @if($links->count() > 0)
        <div class="border-box fill section-toolbox">
            <div class="border-box__header">
                <i class="fa fa-link"></i> Useful Links
            </div>
            <div class="border-box__content border-box__content--text-medium">
                @foreach($links as $link)
                    <div class="toolbox-resource">
                        <div class="row no-margin">
                            <div class="col-4">
                                <div class="toolbox-resource__link">
                                    <strong><a href="{{ $link->url }}" target="_blank">{{ $link->name }}</a></strong><br>
                                </div>
                            </div>
                            @if($user->hasRole('Administrator'))
                                <div class="col-6">
                            @else
                                <div class="col-8">
                            @endif
                                <div class="toolbox-resource__description">
                                    {{ $link->description }}
                                </div>
                            </div>
                            @if($user->hasRole('Administrator'))
                                <div class="col-2">
                                    {{ Form::open(['route' => array('toolbox.destroy', $link->id), 'method' => 'delete']) }}
                                    <button type="submit" class="toolbox-resource__button red-but delete-row" data-resource-type="link"><i class="fa fa-times"></i></button>
                                    {{ Form::close() }}
                                    {{ Form::open(['route' => array('toolbox.edit', $link->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary toolbox-resource__button" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($files->count() > 0)
        <div class="border-box fill section-toolbox">
            <div class="border-box__header">
                <i class="fa fa-file-text"></i> Useful Files
            </div>
            <div class="border-box__content border-box__content--text-medium">
                @foreach($files as $file)
                    <div class="toolbox-resource">
                        <div class="row no-margin">
                            <div class="col-4">
                                <div class="toolbox-resource__link">
                                    <a href="{{ $file->file }}" target="_blank">{{ $file->name }}</a><br>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="toolbox-resource__description">
                                    {{ $file->description }}
                                </div>
                            </div>
                            <div class="col-2">
                                @if($user->hasRole('Administrator'))
                                    {{ Form::open(['route' => array('toolbox.destroy', $file->id), 'method' => 'delete']) }}
                                        <button type="submit" class="toolbox-resource__button red-but delete-row" data-resource-type="file"><i class="fa fa-times"></i></button>
                                    {{ Form::close() }}
                                    {{ Form::open(['route' => array('toolbox.edit', $file->id), 'method' => 'get']) }}
                                        <button type="submit" class="primary toolbox-resource__button" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                @endif
                                <a class="primary toolbox-resource__button" href="{{ $file->file }}" target="_blank"><i class="fa fa-caret-down"></i> Download</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@stop