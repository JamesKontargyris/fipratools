<div class="super-menu__container">
	<div class="container">
		<div class="row">
			<div class="col-7">
				<ul class="super-menu">
					<li class="super-menu__logo hide-s">
						<img src="{{ asset('img/fipra_logo.png') }}" class="hide-m hide-s" alt="Fipra" style="vertical-align:middle"/>
						<img src="{{ asset('img/fipra_logo_s.png') }}" class="hide-l" alt="Fipra" style="vertical-align:middle"/>
					</li>
					<li class="super-menu__item hide-print"><a href="/list" class="super-menu__link <?php if(Session::get('section') == 'list') : ?> active<?php endif; ?> section-list">Lead Office List</a></li>
					<li class="super-menu__item hide-print"><a href="/caselist" class="super-menu__link <?php if(Session::get('section') == 'case') : ?> active<?php endif; ?> section-case">Case Studies</a></li>
					@if($user->can('manage_knowledge')) <li class="super-menu__item hide-print"><a href="/survey" class="super-menu__link <?php if(Session::get('section') == 'survey') : ?> active<?php endif; ?> section-survey">Knowledge Survey</a></li> @endif
				</ul>
			</div>
			<div class="col-5 last super-menu__user-details hide-print">
				Logged in as <strong>{{ $user_full_name }}</strong><br/>
				@if($user_unit)<i class="fa fa-sitemap"></i> {{ $user_unit }}@endif&nbsp;&nbsp;<i class="fa fa-user"></i> {{ $user_role }}
				<br><a href="/password/change">Change Password</a> &nbsp;&nbsp;<a href="/logout">Logout</a>
			</div>
		</div>
	</div>
</div>