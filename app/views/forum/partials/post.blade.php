<tr id="forum__post post-{{ $post->id }}">
	<td class="forum__post__content-cell valign-top">
        <strong class="forum__post__author">{{{ $post->author->getFullName() }}}</strong>
        <br>{{ $post->author->getRole() }}
        @if($post->author->unit_id) <br>{{ \Leadofficelist\Units\Unit::find($post->author->unit_id)->name }} @endif

		<br><br>
		<div class="forum__list__meta">
			{{ trans('forum::base.posted_at') }}: {{ $post->posted }}
			@if ($post->updated_at != null && $post->created_at != $post->updated_at)
				<br>Last edited: {{ $post->updated }}
			@endif
		</div>
	</td>
	<td class="forum__post__content-cell valign-top" @if( ! $user->hasRole('Administrator')) colspan="2" @endif>
		<div class="forum__post__content">{{ str_replace('<p>&nbsp;</p>', '', $post->content) }}</div> {{--Get rid of empty paragraph tags--}}
		@if ($post->canEdit)
            {{ Form::open( [ 'url' => $post->editRoute, 'method' => 'POST', 'class' => 'forum-button-form' ] ) }}
                <button type="submit" class="orange-but but-small"><i class="fa fa-pencil"></i> {{ trans('forum::base.edit')}}</button>
            {{ Form::close() }}
        @endif
        @if($user->hasRole('Administrator'))
            {{ Form::open( [ 'url' => $post->deleteRoute, 'method' => 'DELETE', 'class' => 'forum-button-form' ] ) }}
                <button type="submit" class="red-but but-small delete-row" data-resource-type="post" title="Delete this post"><i class="fa fa-times"></i> Delete</button>
            {{ Form::close() }}
        @endif
	</td>
</tr>
