@extends('layouts.master')

@section('page-header')
    @if(is_search())
        <i class="fa fa-search"></i> Searching for {{ Session::has('network_types.SearchType') ? Session::get('network_types.SearchType') : '' }}: {{ $items->search_term }}
    @else
        Network Types Overview
    @endif
@stop

@section('page-nav')
    <li><a href="{{ route('units.index') }}" class="primary"><i class="fa fa-caret-left"></i> Network Overview</a></li>
    <li><a href="{{ route('network_types.create') }}" class="primary"><i class="fa fa-plus-circle"></i> Add a Network Type</a></li>
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
                            <td width="100%">Type Name</td>
                            <td colspan="2" class="hide-print">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $network_type)
                            <tr>
                                <td><strong>{{ $network_type->name }}</strong></td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('network_types.edit', $network_type->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('network_types.destroy', $network_type->id), 'method' => 'delete']) }}
                                    <button type="submit" class="red-but delete-row" data-resource-type="network type"><i class="fa fa-times"></i></button>
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