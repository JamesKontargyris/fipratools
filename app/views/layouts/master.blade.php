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
				<div class="row">
					<div class="col-12">
						<div id="page-header" class="section-{{ section_is() }}">
							<h2>@yield('page-header')</h2>
							<nav class="page-menu-nav">
								<ul class="small-font">
									@yield('page-nav')
								</ul>
								@if(! is_request('client_links') && ! is_request('client_archives') && ! is_request('widgets'))
									<ul class="small-font">
										@if(isset($items) && ! is_request('about') && ! is_request('survey'))
											<li><a href="/{{ $items->key }}/export?filetype=pdf_all" class="grey-but pdf-export-button"><i class="fa fa-file-pdf-o"></i> Export PDF: All</a></li>
											<!-- if this is the main list and a filter is in place, substitute an export filtered button for the the export visible button -->
											<li><a href="/{{ $items->key }}/export?filetype=pdf_selection&page={{ $items->getCurrentPage() }}" class="grey-but pdf-export-button"><i class="fa fa-file-pdf-o"></i> Export PDF: Visible</a></li>
											<li><a href="/{{ $items->key }}/export?filetype=excel_all" class="grey-but excel-export-button"><i class="fa fa-file-excel-o"></i> Export Excel: All</a></li>
											<li><a href="/{{ $items->key }}/export?filetype=excel_selection&page={{ $items->getCurrentPage() }}" class="grey-but excel-export-button"><i class="fa fa-file-excel-o"></i> Export Excel: Visible</a></li>

											@yield('export-nav')

											<li><a class="print-button grey-but" href="#"><i class="fa fa-print"></i> Print</a></li>
										@endif
									</ul>
								@endif
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

        <div class="container">
            <footer>
                <p>&copy; Fipra <?php echo date("Y"); ?>. All Rights Reserved.<br><a href="http://fipra.com/other~3/code_of_conduct~7/" target="_blank">Code of conduct</a></p>
            </footer>
        </div>

		@include('layouts.partials.scripts')

    </body>
</html>