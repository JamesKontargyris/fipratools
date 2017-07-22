<tr id="forum__post post-{{ $post->id }}">
	<td valign="top" class="forum__post__content-cell">
		<strong class="forum__post__author">{{{ $post->author->getFullName() }}}</strong> @if($post->author->unit_id) <br>{{ \Leadofficelist\Units\Unit::find($post->author->unit_id)->name }} @endif
		<br><br>
		<div class="forum__list__meta">
			{{ trans('forum::base.posted_at') }} {{ $post->posted }}
			@if ($post->updated_at != null && $post->created_at != $post->updated_at)
				{{ trans('forum::base.last_update') }} {{ $post->updated }}
			@endif
		</div>
	</td>
	<td valign="top" class="forum__post__content-cell">
		<div class="forum__post__content">{{ $post->content }}</div>
		@if ($post->canEdit)
			<a href="{{ $post->editRoute }}">{{ trans('forum::base.edit')}}</a>
		@endif
		@if ($user->hasRole('Administrator'))
			{{ Form::open( [ 'url' => $post->deleteRoute, 'method' => 'DELETE' ] ) }}
				{{ Form::submit('Delete') }}
			{{ Form::close() }}
		@endif
	</td>
</tr>
