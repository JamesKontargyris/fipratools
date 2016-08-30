<div class="super-menu__container">
	<div class="container">
		<div class="row">
			<div class="col-7">
				<ul class="super-menu">
					<li class="super-menu__logo hide-s"><img src="{{ asset('img/fipra_logo_s.png') }}" alt="Fipra" style="vertical-align:middle"/></li>
					<li class="super-menu__item hide-print"><a href="/list?section=list" class="super-menu__link <?php if(Session::get('section') == 'list') : ?> active<?php endif; ?>">Lead Office List</a></li>
					<li class="super-menu__item hide-print"><a href="/list?section=case" class="super-menu__link <?php if(Session::get('section') == 'case') : ?> active<?php endif; ?>">Case Studies</a></li>
					<li class="super-menu__item hide-print"><a href="/survey?section=survey" class="super-menu__link <?php if(Session::get('section') == 'survey') : ?> active<?php endif; ?>">Knowledge Survey</a></li>
				</ul>
			</div>
			<div class="col-5 last super-menu__user-details hide-print">
				Logged in as <strong>{{ $user_full_name }}</strong><br/>
				<i class="fa fa-sitemap"></i> {{ $user_unit }} &nbsp;&nbsp;<i class="fa fa-user"></i> {{ $user_role }} &nbsp;&nbsp;<a href="/logout">Logout</a>
			</div>
		</div>
	</div>
</div>