<!-- resources/views/home.blade.php -->

<html>
<head>
    <title>Home</title>
</head>
<body>
    @if (Auth::check())
        <h1>Welcome, {{ $user->name }}</h1>
        <p>Email: {{ $user->email }}</p>
        <!-- Add more data fields here as needed -->
    @else
        <p>You are not logged in. Please <a href="{{ route('login') }}">login</a> to view this page.</p>
    @endif
</body>
</html>
