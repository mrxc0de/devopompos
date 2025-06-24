<h1>{{ $meeting->title }}</h1>
<p><strong>Date:</strong> {{ \Carbon\Carbon::parse($meeting->datetime)->format('F j, Y, g:i A') }}</p>
<p>{{ $meeting->description }}</p>
