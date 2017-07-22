@extends('layouts.master')

@section('page-header')
	Fipra Forum
@stop

@section('page-nav')
@stop

@section('content')
{{--@include('forum.partials.breadcrumbs')--}}

<section class="index-table-container">
	<div class="row">
		<div class="col-12">
			@foreach($categories as $category)
				<div class="forum__group">
					<div class="forum__titles">
						<div class="forum__title"><i class="fa fa-comments"></i> {{{ $category->title }}}</div>
						<div class="forum__subtitle">{{{ $category->subtitle }}}</div>
					</div>

					<div class="forum__list">
						<table width="100%" class="index-table">
							<thead>
							<tr>
								<td width="90%">Topics</td>
								<td width="10%" class="content-center">Threads</td>
							</tr>
							</thead>
							<tbody>
							@if (!$category->subcategories->isEmpty())
								@foreach ($category->subcategories as $subcategory)
									<tr>
										<td>
											<a href="{{ $subcategory->Route }}" class="forum__topic-title">{{{ $subcategory->title }}}</a>
											<div class="forum__topic-subtitle">{{{ $subcategory->subtitle }}}</div>
											@if ($subcategory->newestThread)
												<div class="forum__list__meta">
													{{ trans('forum::base.newest_thread') }}:
													<a href="{{ $subcategory->newestThread->route }}">
														<strong>{{{ $subcategory->newestThread->title }}}</strong> by {{{ $subcategory->newestThread->author->getFullName() }}} @if($subcategory->newestThread->author->unit_id) ({{ \Leadofficelist\Units\Unit::find($subcategory->newestThread->author->unit_id)->name }}) @endif
													</a>
												</div>
												<div class="forum__list__meta">
													{{ trans('forum::base.last_post') }}:
													<a href="{{ $subcategory->latestActiveThread->lastPost->route }}">
														<strong>{{{ $subcategory->latestActiveThread->title }}}</strong>
														by {{{ $subcategory->latestActiveThread->author->getFullName() }}} @if($subcategory->latestActiveThread->author->unit_id) ({{ \Leadofficelist\Units\Unit::find($subcategory->latestActiveThread->author->unit_id)->name }}) @endif
													</a>
												</div>
											@endif
										</td>
										<td class="content-center">{{ Riari\Forum\Models\Thread::where('parent_category', '=', $subcategory->id)->count() }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<th colspan="3">
										{{ trans('forum::base.no_categories') }}
									</th>
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