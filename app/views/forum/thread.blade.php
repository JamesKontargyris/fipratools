@extends('layouts.forum')

@section('page-header')
    @if ($thread->locked)
        <i class="fa fa-lock text--red"></i>
    @endif
    @if ($thread->pinned)
        <i class="fa fa-thumb-tack text--green"></i>
    @endif

    {{{ $thread->title }}}
@stop

@section('content')
@include('forum.partials.breadcrumbs')

@if ($thread->canLock || $thread->canPin || $thread->canDelete)
    <div class="thread-tools">
        @if ($thread->canLock)
            {{ Form::open(['url' => $thread->lockRoute]) }}
            {{ Form::submit('Lock/unlock this topic') }}
            {{ Form::close() }}
        @endif
        @if ($thread->canPin)
            {{ Form::open(['url' => $thread->pinRoute]) }}
            {{ Form::submit('Pin/unpin this topic') }}
            {{ Form::close() }}
        @endif
        @if ($thread->canDelete)
            {{ Form::open(['url' => $thread->deleteRoute, 'method' => 'DELETE', 'class' => 'js-confirm']) }}
            {{ Form::submit('Delete this topic') }}
            {{ Form::close() }}
        @endif
    </div>
@endif

<p><a href="#quick-reply" class="secondary"><i class="fa fa-comment"></i> Reply</a></p>


{{ $thread->pageLinks }}

<section class="forum-table-container">
    <div class="row no-margin">
        <div class="col-12">
            <div class="forum__group">
                <table width="100%" class="forum-list-table">
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
    </div>
</section>

{{ $thread->pageLinks }}

@if ($thread->canReply)
    <div class="forum__reply-form">
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
    </div>
@endif
@if ($thread->locked)
    <br><h6>This thread is locked. No further replies can be submitted.</h6>
@endif
@overwrite
