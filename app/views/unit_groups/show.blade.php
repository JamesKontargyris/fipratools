@extends('layouts.master')

@section('page-header')
    {{ $unit_group->name }}
@stop

@section('page-nav')
    <li><a href="/units/{{ $unit_group->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this sector category</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    <div class="row">
        <h3>Units in this group:</h3>
    </div>
    @if(count($items) > 0)

        <section class="index-table-container">
            <div class="row">
                <div class="col-12">
                    <table width="100%" class="index-table">
                        <thead>
                        <tr>
                            <td width="100%">Unit Name</td>
                            <td colspan="2" class="hide-print">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $unit)
                            <tr>
                                <td><strong><a href="/units/{{ $unit->id }}">{{ $unit->name }}</a></strong></td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('units.edit', $unit->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </td>
                                <td class="actions content-right hide-print">
                                    {{ Form::open(['route' => array('units.destroy', $unit->id), 'method' => 'delete']) }}
                                    <button type="submit" class="red-but delete-row" data-resource-type="unit"><i class="fa fa-times"></i></button>
                                    {{ Form::close() }}
                                </td>
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