@extends('layouts.master')

@section('page-header')
    @if(is_search()) <i class="fa fa-search"></i> Searching for: {{ $items->search_term }} @else Unit Reporting Group Overview @endif
@stop

@section('page-nav')
    <li><a href="{{ route('units.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Units Overview</a></li>
    <li><a href="{{ route('unit_groups.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Unit Reporting Group</a></li>
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
                            <td width="70%">Group Name</td>
                            <td width="30%">Group Short Name</td>
                            <td colspan="2" class="hide-print">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $unit_group)
                            <tr>
                                <td><strong><a href="/unit_groups/{{ $unit_group->id }}">{{ $unit_group->name }}</a></strong></td>
                                <td><strong>{{ $unit_group->short_name }}</strong></td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('unit_groups.edit', $unit_group->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('unit_groups.destroy', $unit_group->id), 'method' => 'delete']) }}
                                    <button type="submit" class="red-but delete-row" data-resource-type="unit group"><i class="fa fa-times"></i></button>
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