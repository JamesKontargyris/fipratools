@extends('layouts.master')

@section('page-header')
    {{{ $thread->title }}}

    @if ($thread->locked)
        [{{ trans('forum::base.locked') }}]
    @endif
    @if ($thread->pinned)
        [{{ trans('forum::base.pinned') }}]
    @endif
@stop

@section('page-nav')
    @if ($thread->canReply)
          <li><a href="#quick-reply" class="secondary">{{ trans('forum::base.new_reply') }}</a></li>
    @endif
@stop

@section('content')
@include('forum.partials.breadcrumbs')

@if ($thread->canLock || $thread->canPin || $thread->canDelete)
    <div class="thread-tools dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" id="thread-actions" data-toggle="dropdown" aria-expanded="true">
            {{ trans('forum::base.actions') }}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            @if ($thread->canLock)
                <li>{{ Form::inline($thread->lockRoute, array(), ['label' => trans('forum::base.lock_thread')]) }}</li>
            @endif
            @if ($thread->canPin)
                <li>{{ Form::inline($thread->pinRoute, array(), ['label' => trans('forum::base.pin_thread')]) }}</li>
            @endif
            @if ($thread->canDelete)
                <li>{{ Form::inline($thread->deleteRoute, ['method' => 'DELETE', 'data-confirm' => true], ['label' => trans('forum::base.delete_thread')]) }}</li>
            @endif
        </ul>
    </div>
    <hr>
@endif

<section class="index-table-container">
    <div class="row">
        <div class="col-12">
            <table width="100%" class="index-table">
                <thead>
                <tr>
                    <td width="20%">{{ trans('forum::base.author') }}</td>
                    <td colspan="2" width="80%">{{ trans('forum::base.post') }}</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($thread->postsPaginated as $post)
                    @include('forum.partials.post', compact('post'))
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{ $thread->pageLinks }}

@if ($thread->canReply)
    <br><hr>
    <h3 class="no-padding">Post a reply</h3>
    <div id="quick-reply">
        @include(
            'forum.partials.forms.post',
            array(
                'form_url'            => $thread->replyRoute,
                'form_classes'        => '',
                'show_title_field'    => false,
                'post_content'        => '',
                'submit_label'        => trans('forum::base.reply'),
                'cancel_url'          => ''
            )
        )
    </div>
@endif
@overwrite
