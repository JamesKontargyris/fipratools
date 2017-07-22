{{ Form::open( [ 'url' => $form_url, 'class' => $form_classes ] ) }}

@if ( $show_title_field )
<div class="formfield">
    <label for="title">{{ trans('forum::base.title') }}</label>
    {{ Form::text('title', Input::old('title'), ['class' => 'form-control']) }}
</div>
@endif

<div class="formfield">
    @if(Route::currentRouteName() == 'forum.get.create.thread') {{--This is the thread creation page, rather than the post creation page--}}
        <label for="content">First post in this thread</label>
    @endif
    {{ Form::textarea('content', $post_content, ['class' => 'wysiwyg-editor']) }} {{--Only make this a WYSIWYG editor if it's the new reply page--}}
</div>

<button type="submit" class="primary">{{ $submit_label }}</button>
@if ( $cancel_url )
    <a href="{{ $cancel_url }}" class="secondary">{{ trans('forum::base.cancel') }}</a>
@endif

{{ Form::close() }}
