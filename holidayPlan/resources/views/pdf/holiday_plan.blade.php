<!DOCTYPE html>
<html>
<head>
    <title>Holiday Plan</title>
</head>
<body>
    <h1>{{ $plan->title }}</h1>
    <p><strong>Description:</strong> {{ $plan->description }}</p>
    <p><strong>Date:</strong> {{ $plan->date->format('Y-m-d') }}</p>
    <p><strong>Location:</strong> {{ $plan->location }}</p>
    @if ($plan->participants)
        <p><strong>Participants:</strong></p>
        <ul>
            @foreach (json_decode($plan->participants) as $participant)
                <li>{{ $participant }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>
