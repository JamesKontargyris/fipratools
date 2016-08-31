@if( ! Request::is('login'))
    <title>Fipra Portal :: {{ current_section_name() }} {{ isset($page_title) ? ' :: ' . $page_title : '' }}</title>
@else
    <title>Fipra Portal :: Login</title>
@endif