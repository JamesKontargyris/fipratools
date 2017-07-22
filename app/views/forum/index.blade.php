@extends('layouts.forum')

@section('page-header')
	Fipra Forum
@stop

@section('page-nav')
@stop

@section('content')
{{--@include('forum.partials.breadcrumbs')--}}

<h2 class="forum__page-title">Fipra Forums</h2>

<section class="index-table-container">
	<div class="row">
		<div class="col-12">
			@foreach($categories as $category)
				<div class="forum__group">
					<div class="forum__titles">
						<div class="forum__title">{{{ $category->title }}}</div>
						{{--<div class="forum__subtitle">{{{ $category->subtitle }}}</div>--}}
					</div>

					<div class="forum__list">
						<table width="100%" class="forum-list-table">
							<thead>
							<tr>
								<td width="50%">Forum</td>
								<td width="10%">Stats</td>
								<td width="30%" class="content-center">Latest Post</td>
							</tr>
							</thead>
							<tbody>
							@if (!$category->subcategories->isEmpty())
								@foreach ($category->subcategories as $subcategory)
									<tr>
										<td>
											<a href="{{ $subcategory->Route }}" class="forum__topic-title">{{{ $subcategory->title }}}</a>
											{{{ $subcategory->subtitle }}}
										</td>
										<td>Topics: <strong>{{ Riari\Forum\Models\Thread::where('parent_category', '=', $subcategory->id)->count() }}</strong><br>Posts: <strong>{{ Riari\Forum\Models\Thread::where('parent_category', '=', $subcategory->id)->count() }}</strong></td>
										<td>
											@if ($subcategory->newestThread)
												<a href="{{ $subcategory->latestActiveThread->lastPost->route }}">
													<strong class="forum__latest-post-title">{{{ $subcategory->latestActiveThread->title }}}</strong>
												</a><br>
												by {{{ $subcategory->latestActiveThread->author->getFullName() }}} @if($subcategory->latestActiveThread->author->unit_id) ({{ \Leadofficelist\Units\Unit::find($subcategory->latestActiveThread->author->unit_id)->name }}) @endif
												<br>
												{{{ date('j M Y \a\t h:i', strtotime($subcategory->latestActiveThread->updated_at)) }}}
												</a>
											@endif
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="3">
										{{ trans('forum::base.no_categories') }}
									</td>
								</tr>
							@endif

							</tbody>
						</table>
					</div>

				</div>
			@endforeach
		</div>
	</div>
</section>



<h2>{{ trans('forum::base.index') }}</h2>

@stop