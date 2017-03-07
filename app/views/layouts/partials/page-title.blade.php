@if( ! Request::is('login') || ! is_request('password'))
    <title>Fipra Tools :: {{ current_section_name() }} {{ isset($page_title) ? ' :: ' . $page_title : '' }}</title>
@elseif(Request::is('login'))
    <title>Fipra Tools :: Login</title>
@elseif(Request::is('password'))
    <title>Fipra Tools :: Password Management</title>
@endif