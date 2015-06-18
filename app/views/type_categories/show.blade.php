@extends('layouts.master')

@section('page-header')
    {{ $type_category->name }}
@stop

@section('page-nav')
    <li><a href="/type_categories/{{ $type_category->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this type reporting category</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    <div class="row">
        <h3>Types in this reporting category:</h3>
    </div>

    @if(count($items) > 0)

        <section class="index-table-container">
            <div class="row">
                <div class="col-12">
                    <table width="100%" class="index-table">
                        <thead>
                        <tr>
                            <td width="100%">Type Name</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $type)
                            <tr>
                                <td><strong><a href="/types/{{ $type->id }}">{{ $type->name }}</a></strong></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    @else
        @include('layouts.partials.index_no_records_found')
    @endif

    @include('layouts.partials.back_button')

    @include('layouts.partials.messages')
@stop