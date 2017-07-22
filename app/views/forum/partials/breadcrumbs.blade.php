<ol class="forum__breadcrumbs">
    <li class="forum__breadcrumbs__item"><a class="forum__breadcrumbs__link" href="{{ Config::get('forum::routes.root') }}">Forum {{ trans('forum::base.index') }}</a></li>
    @if (isset($parentCategory) && $parentCategory)
        <li class="forum__breadcrumbs__item"><a class="forum__breadcrumbs__link" href="{{{ $parentCategory->route }}}">{{{ $parentCategory->title }}}</a></li>
    @endif
    @if (isset($category) && $category)
        <li class="forum__breadcrumbs__item"><a class="forum__breadcrumbs__link" href="{{{ $category->route }}}">{{{ $category->title }}}</a></li>
    @endif
    @if (isset($thread) && $thread)
        <li class="forum__breadcrumbs__item"><a class="forum__breadcrumbs__link" href="{{{ $thread->route }}}">{{{ $thread->title }}}</a></li>
    @endif
    @if (isset($other) && $other)
        <li class="forum__breadcrumbs__item">{{{ $other }}}</li>
    @endif
</ol>
