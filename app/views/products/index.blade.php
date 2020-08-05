@extends('layouts.master')

@section('page-header')
    @if(is_search())
        <i class="fa fa-search"></i> Searching for {{ Session::has('products.SearchType') ? Session::get('products.SearchType') : '' }}: {{ $items->search_term }}
    @else
        Products Overview
    @endif
@stop

@section('page-nav')
    <li><a href="{{ route('products.create') }}" class="primary"><i class="fa fa-plus-circle"></i> Add a Product</a></li>
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
                            <td rowspan="2" width="75%">Product Name</td>
                            <td rowspan="2" colspan="2" class="hide-print">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $product)
                            <tr>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('products.edit', $product->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('products.destroy', $product->id), 'method' => 'delete']) }}
                                    <button type="submit" class="red-but delete-row" data-resource-type="location"><i class="fa fa-times"></i></button>
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