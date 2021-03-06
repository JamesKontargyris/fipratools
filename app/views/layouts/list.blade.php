<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        @include('layouts.partials.page-head')
    </head>
    <body>
		@include('layouts.partials.nav')

        <section class="content-container">

			<section id="content">
					<div class="row no-margin">
						<div class="col-12">
							<div id="page-header" class="section-{{ section_is() }}">
								<h2>@if($sitewide && $user->hasRole('Administrator')) <div class="sitewide tooltip-left hide-print" data-tooltip="This data is used across sections"><i class="fa fa-arrows-alt sitewide__icon"></i> <span class="sitewide__title hide-s hide-m">Sitewide</span></div>@endif @yield('page-header')</h2>
								<nav class="page-menu-nav">
									<ul class="small-font">
                                        @yield('page-nav')
									</ul>
									<ul class="small-font">
										<li><a href="/{{ $items->key }}/export?filetype=pdf_all" class="secondary pdf-export-button"><i class="fa fa-file-pdf-o"></i> Export PDF: All</a></li>
										@if(is_filter($items->key))
											<li><a href="/{{ $items->key }}/export?filetype=pdf_filtered" class="secondary pdf-export-button"><i class="fa fa-file-pdf-o"></i> Export PDF: Filtered</a></li>
										@else
											<li><a href="/{{ $items->key }}/export?filetype=pdf_selection&page={{ $items->getCurrentPage() }}" class="secondary pdf-export-button"><i class="fa fa-file-pdf-o"></i> Export PDF: Visible</a></li>
										@endif
										<li><a href="/{{ $items->key }}/export?filetype=excel_all" class="secondary excel-export-button"><i class="fa fa-file-excel-o"></i> Export Excel: All</a></li>
										@if(is_filter($items->key))
											<li><a href="/{{ $items->key }}/export?filetype=excel_filtered" class="secondary excel-export-button"><i class="fa fa-file-excel-o"></i> Export Excel: Filtered</a></li>
										@else
											<li><a href="/{{ $items->key }}/export?filetype=excel_selection&page={{ $items->getCurrentPage() }}" class="secondary excel-export-button"><i class="fa fa-file-excel-o"></i> Export Excel: Visible</a></li>
										@endif


										@yield('export-nav')

										<li><a class="print-button secondary" href="#"><i class="fa fa-print"></i> Print</a></li>
									</ul>
								</nav>
								<a href="#" class="page-menu-icon-s">
									Actions <i class="fa fa-lg fa-caret-down"></i>
								</a>
							</div>
						</div>
					</div>

				@yield('content')

			</section>

        </section>

		@include('layouts.partials.footer')

	@include('layouts.partials.scripts')

    </body>
</html>