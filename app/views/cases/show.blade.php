@extends('layouts.master')

@section('page-header')
    Case Study
@stop

@section('page-nav')
    <li><a href="{{ URL::previous() }}" class="primary"><i class="fa fa-caret-left"></i> Go back</a></li>
    @if($user->unit_id == $case->unit_id || $user->hasRole('Administrator'))
        <li><a href="/cases/{{ $case->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this case study</a></li>
    @endif
@stop

@section('content')

    @include('layouts.partials.messages')

    <div class="row">
        <div class="col-8">
            <div class="border-box fill section-case">
                <div class="border-box__content border-box__content--text-medium">
                    <div class="border-box__title">Background</div>
                    <p>{{ $case->name }}</p>
                </div>
            </div>
            <div class="border-box fill section-case">
                <div class="border-box__content border-box__content--text-medium">
                    <div class="border-box__title">Challenges facing client/Fipra</div>
                    <p>{{ $case->challenges }}</p>
                </div>
            </div>
            <div class="border-box fill section-case">
                <div class="border-box__content border-box__content--text-medium">
                    <div class="border-box__title">What Fipra did to overcome the challenges</div>
                    <p>{{ $case->strategy }}</p>
                </div>
            </div>
            <div class="border-box fill section-case">
                <div class="border-box__content border-box__content--text-medium">
                    <div class="border-box__title">End result</div>
                    <p class="no-padding">{{ $case->result }}</p>
                </div>
            </div>
        </div>
        <div class="col-4 last">
            <div class="border-box section-case">
                <div class="border-box__content">
                    <div class="row no-margin">
                        <div class="col-6">
                            <div class="border-box__sub-title">Client</div>
                            <p>{{ ! $case->client_id ? (! $case->client ? 'Anonymous' : $case->client) : '<a href="' . route('clients.show', $case->client()->first()->id) . '">' . $case->client()->first()->name . '</a>' }}</p>
                            <div class="border-box__sub-title">Year</div>
                            <p>{{ $case->year }}</p>
                        </div>
                        <div class="col-6 last">
                            <div class="border-box__sub-title">Unit</div>
                            <p><a href="{{ route('units.show', $case->unit()->pluck('id')) }}">{{ $case->unit()->pluck('name') }}</a></p>
                            <div class="border-box__sub-title">AD to talk to</div>
                            <p>{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</p>
                        </div>
                    </div>
                    <div class="row no-margin">
                        <div class="col-12">
                            <div class="border-box__sub-title">Sector(s)</div>
                            <p>{{ get_pretty_sector_names(unserialize($case->sector_id)); }}</p>
                            <div class="border-box__sub-title">Product(s)</div>
                            <p class="no-padding">{{ get_pretty_product_names(unserialize($case->product_id)); }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop