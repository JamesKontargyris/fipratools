<tr id="forum__post post-{{ $post->id }}">
	<td valign="top" class="forum__post__content-cell">
        <strong class="forum__post__author">{{{ $post->author->getFullName() }}}</strong>
        <br>{{ $post->author->getRole() }}
        @if($post->author->unit_id) <br>{{ \Leadofficelist\Units\Unit::find($post->author->unit_id)->name }} @endif

		<br><br>
		<div class="forum__list__meta">
			{{ trans('forum::base.posted_at') }} {{ $post->posted }}
		</div>
	</td>
	<td valign="top" class="forum__post__content-cell" @if( ! $user->hasRole('Administrator')) colspan="2" @endif>
		<div class="forum__post__content">{{ str_replace('<p>&nbsp;</p>', '', $post->content) }}</div> {{--Get rid of empty paragraph tags--}}
		@if ($post->updated_at != null && $post->created_at != $post->updated_at)
			<div class="forum__list__meta">Last edited: {{ $post->updated }}</div>
		@endif
		@if ($post->canEdit)
            <br>
            {{ Form::open( [ 'url' => $post->editRoute, 'method' => 'POST', 'class' => 'forum-button-form' ] ) }}
                <button type="submit" class="orange-but"><i class="fa fa-pencil"></i> {{ trans('forum::base.edit')}}</button>
            {{ Form::close() }}
        @endif
        @if($user->hasRole('Administrator'))
            {{ Form::open( [ 'url' => $post->deleteRoute, 'method' => 'DELETE', 'class' => 'forum-button-form' ] ) }}
                <button type="submit" class="red-but delete-row" data-resource-type="post" title="Delete this post"><i class="fa fa-times"></i> Delete</button>
            {{ Form::close() }}
        @endif
	</td>
</tr>
