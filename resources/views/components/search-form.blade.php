<form action="{{ route($routeName) }}" method="GET">
    <input type="text" name="search" required placeholder="Search..." value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>
