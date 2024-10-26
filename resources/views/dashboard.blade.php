<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="container">
        <h2>Welcome, {{ session('name') }}</h2>
        <form action="{{ route('joke.fetch') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Fetch a Joke</button>
        </form>

        <div class="mt-3">
            <h3>Your Joke:</h3>
            <p>{{ session('joke') ? session('joke') : 'No joke fetched yet!' }}</p>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Logout</button>
        </form>
    </div>
</body>
</html>
