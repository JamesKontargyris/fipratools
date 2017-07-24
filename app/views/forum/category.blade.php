@extends('layouts.forum')

@section('page-header')
	'{{ $category->title }}' Forum
@stop

@section('content')
@include('forum.partials.breadcrumbs')

@if ($category->canPost)
	<a href="{{ $category->newThreadRoute }}" class="secondary but-small"><i class="fa fa-plus-circle"></i> New topic</a>
	<br><br>
@endif

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<div class="forum__group">
					<table width="100%" class="forum-list-table">
						<thead>
						<tr>
							<td width="60%">Topic</td>
							<td width="10%">Stats</td>
							<td width="30%" class="hide-s">Last Post</td>
						</tr>
						</thead>
						<tbody>
						@if (!$category->threadsPaginated->isEmpty())
							@foreach ($category->threadsPaginated as $thread)
								<tr>
									<td>
										<div class="forum__topic-title">
											@if ($thread->locked)
												<i class="fa fa-lock text--red" title="Locked topic - no further replies"></i>
											@endif
											@if ($thread->pinned)
												<i class="fa fa-thumb-tack text--green" title="Pinned topic"></i>
											@endif
											@if($thread->userReadStatus)
													<i class="fa fa-dot-circle-o text--orange" title="Unread posts"></i>
											@endif
											<a href="{{ $thread->route }}">{{ $thread->title }}</a>
										</div>
										<div class="forum__topic-subtitle">Created {{ $thread->posted }}</div>
									</td>
									<td>
										Replies: <strong>{{ $thread->replyCount }}</strong>
									</td>
									<td class="hide-s">
										<strong>{{{ $thread->lastPost->author->getFullName() }}}</strong> @if($thread->lastPost->author->unit_id) ({{ \Leadofficelist\Units\Unit::find($thread->lastPost->author->unit_id)->name }}) @endif
										<div class="forum__list__meta">{{ $thread->lastPost->posted }} &bull; <a href="{{ URL::to( $thread->lastPostRoute ) }}">{{ trans('forum::base.view_post') }} &raquo;</a></div>
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td>
									No topics found.
								</td>
								<td colspan="2">
									@if ($category->canPost)
										<a href="{{ $category->newThreadRoute }}">Create a topic</a>
									@endif
								</td>
							</tr>
						@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>


{{ $category->pageLinks }}

@if ($category->canPost)
	<a href="{{ $category->newThreadRoute }}" class="secondary but-small"><i class="fa fa-plus-circle"></i> New topic</a>
@endif
@overwrite
