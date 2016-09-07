<p>Users who signed up for {{ $school }} today:</p>
@if (!count($users))
<p>No users today.</p>
@endif
@foreach ($users as $user)
<p>{{ $user }}</p>
@endforeach