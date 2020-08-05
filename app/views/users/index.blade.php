@extends('layouts.master')

@section('page-header')
	@if(is_search())
		<i class="fa fa-search"></i> Searching for {{ Session::has('users.SearchType') ? Session::get('users.SearchType') : '' }}: {{ $items->search_term }}
	@else
		Users
	@endif
@stop

@section('page-nav')
<li><a href="{{ route('users.create') }}" class="primary"><i class="fa fa-plus-circle"></i> Add a User</a></li>
@stop

@section('export-nav')
@stop

@section('content')

@include('layouts.partials.messages')

@if(count($items) > 0)
	@include('layouts.partials.rows_nav')

	@include('layouts.partials.filters')

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td rowspan="2" colspan="2" width="40%">User</td>
							<td rowspan="2" width="15%" class="hide-s">Email</td>
							<td rowspan="2" width="10%" class="hide-s">Role</td>
							<td colspan="2" width="10%" class="content-center hide-s">Clients Added</td>
							<td rowspan="2" colspan="2" class="hide-print">Actions</td>
						</tr>
						<tr>
							<td class="sub-header content-center hide-s">Active</td>
							<td class="sub-header content-center hide-s">Dormant</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $list_user)
							<tr>
								<td>
									<strong>
										@if(Session::get ('users.rowsNameOrder') == 'last_first')
											{{ $list_user->getFullName(true) }}
										@else
											{{ $list_user->getFullName(false) }}
										@endif
									</strong>
								</td>
								<td class="actions knowledge-survey-link">
									{{--Knowledge survey link--}}
									@if($list_user->survey_updated && $list_user->date_of_birth != '0000-00-00')
										<a href="{{ route('survey.show', $list_user->id) }}" alt="View {{ $list_user->first_name }}'s Knowledge Profile" title="View {{ $list_user->first_name }}'s Knowledge Profile"><i class="fa fa-book fa-lg"></i></a>
									@endif
								</td>
								<td class="hide-s">{{ $list_user->email }}</td>
								<td class="hide-s">{{ $list_user->roles()->pluck('name') }}</td>
								<td class="content-center hide-s">{{ number_format($list_user->clients()->where('status', '=', 1)->count(),0,0,',') }}</td>
								<td class="content-center hide-s">{{ number_format($list_user->clients()->where('status', '=', 0)->count(),0,0,',') }}</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('users.edit', $list_user->id), 'method' => 'get']) }}
										<button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('users.destroy', $list_user->id), 'method' => 'delete']) }}
										<button type="submit" class="red-but delete-row" data-resource-type="user"><i class="fa fa-times"></i></button>
									{{ Form::close() }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>

	@include('layouts.partials.pagination_container')
@else
	@include('layouts.partials.index_no_records_found')
@endif
@stop