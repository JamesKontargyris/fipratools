@if( ! Request::is('login') || ! is_request('password'))
    <title>Fipra Portal :: {{ current_section_name() }} {{ isset($page_title) ? ' :: ' . $page_title : '' }}</title>
@elseif(Request::is('login'))
    <title>Fipra Portal :: Login</title>
@elseif(Request::is('password'))
    <title>Fipra Portal :: Password Management</title>
@endif