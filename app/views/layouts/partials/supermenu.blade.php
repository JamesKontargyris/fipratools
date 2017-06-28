<div class="super-menu__container">
	<div class="container">
		<div class="row">
			<div class="col-9">
				<ul class="super-menu">
					<li class="super-menu__logo hide-s">
						<img src="{{ asset('img/fipra_logo.png') }}" class="hide-m hide-s" alt="Fipra" style="vertical-align:middle"/>
						<img src="{{ asset('img/fipra_logo_s.png') }}" class="hide-l" alt="Fipra" style="vertical-align:middle"/>
					</li>
					@if($user->can('view_list'))
						<li class="super-menu__item hide-print"><a href="/list?global=list" class="super-menu__link <?php if(Session::get('section') == 'list') : ?> active<?php endif; ?> section-list">Lead Office List</a></li>
					@endif

					@if($user->can('view_cases'))
						<li class="super-menu__item hide-print"><a href="/caselist?global=case" class="super-menu__link <?php if(Session::get('section') == 'case') : ?> active<?php endif; ?> section-case">Case Studies</a></li>
					@endif

					@if($user->can('view_knowledge'))
						<li class="super-menu__item hide-print"><a href="/survey?global=survey" class="super-menu__link <?php if(Session::get('section') == 'survey') : ?> active<?php endif; ?> section-survey">Knowledge Survey</a></li>
					@endif

					@if($user->hasRole( 'Head of Unit') || $user->hasRole( 'Administrator'))
						<li class="super-menu__item hide-print"><a href="/headofunitsurvey?global=headofunitsurvey" class="super-menu__link <?php if(Session::get('section') == 'headofunitsurvey') : ?> active<?php endif; ?> section-headofunitsurvey">Head of Unit Survey</a></li>
					@endif

					@if( ! $user->hasRole('Special Adviser'))
						<li class="super-menu__item hide-print"><a href="/iwo?global=iwo" class="super-menu__link <?php if(Session::get('section') == 'iwo') : ?> active<?php endif; ?> section-iwo">IWO</a></li>
					@endif;

					@if($user->can('view_toolbox'))
						<li class="super-menu__item hide-print"><a href="/toolbox?global=toolbox" class="super-menu__link <?php if(Session::get('section') == 'toolbox') : ?> active<?php endif; ?> section-toolbox">Toolbox</a></li>
					@endif
				</ul>
			</div>
			<div class="col-3 last super-menu__user-details hide-print">
				Logged in as <strong>{{ $user_full_name }}</strong><br/>
				@if($user_unit)<i class="fa fa-sitemap"></i> {{ $user_unit }}@endif&nbsp;&nbsp;<i class="fa fa-user"></i> {{ $user_role }}
				<br><a href="/password/change">Change Password</a> &nbsp;&nbsp;<a href="/logout">Logout</a>
			</div>
		</div>
	</div>
</div>