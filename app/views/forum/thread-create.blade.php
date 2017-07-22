@extends('layouts.master')

@section('page-header')
    Fipra Forum: Create new thread in '{{ $category->title }}'
@stop

@section('content')
@include('forum.partials.breadcrumbs', compact('parentCategory', 'category', 'thread'))

@include('forum.partials.alerts')

@include(
    'forum.partials.forms.post',
    array(
        'form_url'            => $category->newThreadRoute,
        'form_classes'        => '',
        'show_title_field'    => true,
        'post_content'        => '',
        'submit_label'        => 'Post',
        'cancel_url'          => ''
    )
)
@overwrite
