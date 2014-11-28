<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<style>
		* {
			font-family:arial, sans-serif;
			line-height:1.4;
		}
		</style>
	</head>
	<body>
		<h2>Fipra Lead Office List</h2>
		<h3>Notification Sent: Head of Unit Client Status Check</h3>

		<p>Dear {{ $first_name }},</p>

		<p>An email notification has just been sent to all Lead Office List Head of Unit users asking them to perform a client status check on clients assigned to their Unit.</p>

		<p>There were {{ $count }} users contacted:</p>

		<p>
			@foreach($usernames as $username)
				{{ $username }}<br/>
			@endforeach
		</p>

		<p>You can check the eventlog at <a href="http://leadofficelist.fipra.com/eventlog">leadofficelist.fipra.com/eventlog</a> to monitor client status updates. A log will also be added when a Head of Unit successfully completes the status check process.</p>
	</body>
</html>