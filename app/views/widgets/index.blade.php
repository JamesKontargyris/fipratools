@extends('layouts.master')

@section('page-header')
    @if(is_search())
        <i class="fa fa-search"></i> Searching for {{ Session::has('widgets.SearchType') ? Session::get('widgets.SearchType') : '' }}: {{ $items->search_term }}
    @else
        Widgets Overview
    @endif
@stop

@section('page-nav')
    <li><a href="{{ route('widgets.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Widget</a></li>
@stop

@section('export-nav')
@stop

@section('content')

    @include('layouts.partials.messages')

    @if(count($items) > 0)
        @include('layouts.partials.rows_nav')

        @include('layouts.partials.filters')

        <section class="index-table-container">
            <div class="row">
                <div class="col-12">
                    <table width="100%" class="index-table">
                        <thead>
                        <tr>
                            <td width="50%">Name</td>
                            <td width="50%">Slug</td>
                            <td colspan="2" class="hide-print">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $widget)
                            <tr>
                                <td><strong><a href="{{ route('widgets.show', $widget->id) }}">{{ $widget->name }}</a></strong></td>
                                <td>{{ $widget->slug }}</td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('widgets.edit', $widget->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('widgets.destroy', $widget->id), 'method' => 'delete']) }}
                                    <button type="submit" class="red-but delete-row" data-resource-type="widget"><i class="fa fa-times"></i></button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        @include('layouts.partials.pagination_container')
    @else
        @include('layouts.partials.index_no_records_found')
    @endif
@stop