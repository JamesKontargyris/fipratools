@include('layouts.partials.supermenu')

        <!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<section class="mobile-user-details-container">
    <div class="row">
        <div class="col-12">
            Logged in as <strong>{{ $user_full_name }}</strong><br/>
            {{ $user_unit }} &bull; {{ $user_role }}<br/><a href="/logout" class="primary">Logout</a>
        </div>
    </div>
</section>

<section id="site-nav-container" class="section-{{ section_is(); }}">
    <nav id="site-nav" class="container">
        <div class="mobile">
            <div class="row no-margin">
                <div class="col-8 logo">
                    <img src="{{ asset('img/fipra_logo_s.png') }}" alt="Fipra" style="vertical-align:middle"/>
                    <span>
                                @if(Session::get('section') == 'case')
                            Case Studies
                        @elseif(Session::get('section') == 'survey')
                            Knowledge Survey
                        @else
                            Lead Office List
                        @endif
                        <i class="fa fa-lg fa-caret-down"></i></span>
                </div>
                <div class="col-4 last">
                    <ul class="mobile-nav-buttons">
                        <li><a href="#" class="mobile-user-details-but"><i class="fa fa-2x fa-user"></i></a></li>
                        <li><a href="#" class="mobile-site-nav-but"><i class="fa fa-2x fa-navicon"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <section class="mobile-site-nav-container">
            <div class="row">
                <div class="col-12">
                    @include('layouts.partials.site_nav')
                </div>
            </div>
        </section>
        <div class="desktop">
            <div class="col-12">
                @include('layouts.partials.site_nav')
            </div>
        </div>
    </nav>
</section>