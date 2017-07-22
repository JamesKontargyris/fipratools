{{ Form::open( [ 'url' => $form_url, 'class' => $form_classes ] ) }}

@if ( $show_title_field )
<div class="form-group">
    <label for="title">{{ trans('forum::base.title') }}</label>
    {{ Form::text('title', Input::old('title'), ['class' => 'form-control']) }}
</div>
@endif

<div class="form-group">
    @if(Route::currentRouteName() == 'forum.get.create.thread') {{--This is the thread creation page, rather than the post creation page--}}
        <label for="content">Description</label>
    @endif
    {{ Form::textarea('content', $post_content, ['class' => (Route::currentRouteName() != 'forum.get.create.thread') ? 'wysiwyg-editor' : '']) }}
</div>

<button type="submit" class="primary">{{ $submit_label }}</button>
@if ( $cancel_url )
<a href="{{ $cancel_url }}" class="secondary">{{ trans('forum::base.cancel') }}</a>
@endif

{{ Form::close() }}
