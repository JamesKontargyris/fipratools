@extends('layouts.master')

@section('page-header')
	Fipra Forum: {{ $category->title }}
@stop

@section('page-nav')
	@if ($category->canPost)
		<li><a href="{{ $category->newThreadRoute }}" class="secondary"><i class="fa fa-plus-circle"></i> {{ trans('forum::base.new_thread') }}</a></li>
	@endif
@stop

@section('content')
@include('forum.partials.breadcrumbs')

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
					<tr>
						<td width="70%">Subject</td>
						<td width="10%" class="content-center">Replies</td>
						<td width="20%" class="content-center">Last Post</td>
					</tr>
					</thead>
					<tbody>
							@if (!$category->threadsPaginated->isEmpty())
								@foreach ($category->threadsPaginated as $thread)
									<tr>
										<td>
											@if($thread->locked)
												<span class="label label-danger">{{ trans('forum::base.locked') }}</span>
											@endif
											@if($thread->pinned)
												<span class="label label-info">{{ trans('forum::base.pinned') }}</span>
											@endif
											@if($thread->userReadStatus)
												<span class="label label-primary">{{ trans($thread->userReadStatus) }}</span>
											@endif
											<a href="{{ $thread->route }}" class="forum__topic-title">{{ $thread->title }}</a>
												<div class="forum__topic-subtitle">Created {{ $thread->posted }}</div>
										</td>
										<td class="content-center">
											{{ $thread->replyCount }}
										</td>
										<td>
											{{{ $thread->lastPost->author->getFullName() }}} @if($thread->lastPost->author->unit_id) ({{ \Leadofficelist\Units\Unit::find($thread->lastPost->author->unit_id)->name }}) @endif
											<div class="forum__list__meta">{{ $thread->lastPost->posted }}</div>
											<a href="{{ URL::to( $thread->lastPostRoute ) }}" class="secondary but-small">{{ trans('forum::base.view_post') }} &raquo;</a>
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td>
										{{ trans('forum::base.no_threads') }}
									</td>
									<td colspan="2">
										@if ($category->canPost)
											<a href="{{ $category->newThreadRoute }}">{{ trans('forum::base.first_thread') }}</a>
										@endif
									</td>
								</tr>
							@endif
					</tbody>
				</table>
			</div>
		</div>
	</section>


{{ $category->pageLinks }}

@if ($category->canPost)
	<a href="{{ $category->newThreadRoute }}" class="secondary but-small"><i class="fa fa-plus-circle"></i> {{ trans('forum::base.new_thread') }}</a>
@endif
@overwrite
