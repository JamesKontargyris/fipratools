@extends('layouts.forum')

@section('page-header')
    Fipra Forum: Post reply on '{{ $thread->title }}'
@stop

@section('content')
@include('forum.partials.breadcrumbs', compact('parentCategory', 'category', 'thread'))

@include(
    'forum.partials.forms.post',
    array(
        'form_url'          => $thread->replyRoute,
        'form_classes'      => '',
        'show_title_field'  => false,
        'post_content'      => '',
        'submit_label'      => trans('forum::base.reply'),
        'cancel_url'        => $thread->route
    )
)
@overwrite
