@extends('layouts.master')

@section('page-header')
    @if(is_search())
        <i class="fa fa-search"></i> Searching for {{ Session::has('type_categories.SearchType') ? Session::get('type_categories.SearchType') : '' }}: {{ $items->search_term }}
    @else
        Type Categories Overview
    @endif
@stop

@section('page-nav')
    <li><a href="{{ route('types.index') }}" class="primary"><i class="fa fa-caret-left"></i> Types Overview</a></li>
    <li><a href="{{ route('type_categories.create') }}" class="primary"><i class="fa fa-plus-circle"></i> Add a Type Reporting Category</a></li>
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
                            <td width="70%">Type Category Name</td>
                            <td width="30%">Short Name</td>
                            <td colspan="2" class="hide-print">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $type_category)
                            <tr>
                                <td><strong><a href="/type_categories/{{ $type_category->id }}">{{ $type_category->name }}</a></strong></td>
                                <td><strong>{{ $type_category->short_name }}</strong></td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('type_categories.edit', $type_category->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('type_categories.destroy', $type_category->id), 'method' => 'delete']) }}
                                    <button type="submit" class="red-but delete-row" data-resource-type="type category"><i class="fa fa-times"></i></button>
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