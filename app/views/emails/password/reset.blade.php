<!DOCTYPE html>
<html lang="en-US">
@include('emails.partials.head')
<body>
<h2>Password Reset Request</h2>

<p>Dear {{ $name }},</p>
<p>We recently received a request to reset your Fipra Portal password.</p>
<p>Your new password is: {{ $new_password }}</p>
<p>Please use this to login at <a href="http://fipraportal.jkd.io">http://fipraportal.jkd.io</a>, in combination with your Fipra email address.</p>
{{--TODO: Change URL--}}

<p>For security reasons, you will be prompted to update your temporary password to something more memorable when you next login.</p>

</body>
</html>