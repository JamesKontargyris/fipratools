@extends('layouts.master')

@section('page-header')
    {{ $case->name }} ({{ $case->year }})
@stop

@section('page-nav')
    @if($user->unit_id == $case->unit_id || $user->hasRole('Administrator'))
        <li><a href="/cases/{{ $case->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this case study</a></li>
    @endif
@stop

@section('content')

    @include('layouts.partials.messages')

    <div class="row">
        <div class="col-6" style="font-size:18px; line-height:30px;">
            <div class="border-box fill">
                <h5 style="color:gray">Background</h5>
                <p style="padding-bottom:0;">{{ $case->background }}</p>
            </div>
            <div class="border-box fill">
                <h5 style="color:gray">Challenges facing client/Fipra</h5>
                <p style="padding-bottom:0;">{{ $case->challenges }}</p>
            </div>
            <div class="border-box fill">
                <h5 style="color:gray">What Fipra did to overcome the challenges</h5>
                <p style="padding-bottom:0;">{{ $case->strategy }}</p>
            </div>
            <div class="border-box fill">
                <h5 style="color:gray">End result</h5>
                <p style="padding-bottom:0;">{{ $case->result }}</p>
            </div>
        </div>
        <div class="col-6 last" style="font-size:18px; line-height:30px;">
            <p><strong>Unit:</strong> {{ $case->unit()->pluck('name') }}</p>
            <p><strong>AD to talk to:</strong> {{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</p>
            <p><strong>Sector:</strong> {{ $case->sector()->pluck('name') }}</p>
            <p><strong>Product(s):</strong> {{ get_pretty_product_names(unserialize($case->product_id)); }}</p>
            @if($case->location)
                <p><strong>Location:</strong> {{ $case->location()->pluck('name') }}</p>
            @endif

        </div>
    </div>

    @include('layouts.partials.back_button')
@stop