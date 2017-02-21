@extends('layouts.master')

@section('page-header')
    @if(is_search())
        <i class="fa fa-search"></i> Searching for {{ Session::has('knowledge_area_groups.SearchType') ? Session::get('knowledge_area_groups.SearchType') : '' }}: {{ $items->search_term }}
    @else
        Knowledge Area Groups Overview
    @endif
@stop

@section('page-nav')
    <li><a href="{{ route('knowledge_area_groups.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Knowledge Area Group</a></li>
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
                            <td rowspan="2" width="60%">Name</td>
                            <td rowspan="2" width="15%">Order</td>
                            <td rowspan="2" colspan="2" class="hide-print">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $area)
                            <tr>
                                <td><strong>{{ $area->name }}</strong></td>
                                <td>{{ $area->order }}</td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('knowledge_area_groups.edit', $area->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('knowledge_area_groups.destroy', $area->id), 'method' => 'delete']) }}
                                    <button type="submit" class="red-but delete-row" data-resource-type="group"><i class="fa fa-times"></i></button>
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