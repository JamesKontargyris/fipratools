@extends('layouts.master')

@section('page-header')
Event Log
@stop

@section('page-nav')
<li><a href="{{ url('eventlog/trash') }}" class="primary trash-logs"><i class="fa fa-trash"></i> Trash All Logs</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

@if(count($items) > 0)
	@include('layouts.partials.pagination_container')
	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<p><em>Times shown are CET.</em></p>
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td colspan="2" width="45%">Event</td>
							<td width="30%">User</td>
							<td width="20%">When</td>
							<td class="hide-print"></td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $log)
							<tr>
								<td class="event-log-icons narrow no-border-right">
								@if($log->type == 'add')
									<i class="fa fa-lg fa-plus-circle green event-log-icon"></i>
								@elseif($log->type == 'edit')
									<i class="fa fa-lg fa-pencil orange event-log-icon"></i>
								@elseif($log->type == 'delete')
									<i class="fa fa-lg fa-times-circle red event-log-icon"></i>
								@elseif($log->type == 'info')
									<i class="fa fa-lg fa-info-circle turquoise event-log-icon"></i>
								@elseif($log->type == 'error')
                                	<i class="fa fa-lg fa-user red event-log-icon"></i>
								@else
									<i class="fa fa-lg fa-table periwinkle event-log-icon"></i>
								@endif
								</td>
								<td><strong>{{ $log->event }}</strong></td>
								<td>@if($log->user_name){{ $log->user_name }}@endif @if($log->unit_name)({{ $log->unit_name }})@endif</td>
								<td>{{ date('d M Y \a\t g.ia', strtotime($log->created_at)) }}</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['url' => array('eventlog/delete'), 'method' => 'post']) }}
										{{ Form::hidden('log_id', $log->id) }}
										<button type="submit" class="red-but delete-row" data-resource-type="log entry"><i class="fa fa-times"></i></button>
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