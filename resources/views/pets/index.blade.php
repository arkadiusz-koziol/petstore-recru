@include('layouts.default')
    <!DOCTYPE html>
<html>
<head>
    <title>Pet Management - Dashboard</title>
</head>
<body>
<h1>Pet Management Dashboard</h1>

<ul>
    <li><a href="{{ route('pet.form.create') }}">Add a Pet</a></li>
    <li><a href="{{ route('pet.form.show') }}">Show a Pet</a></li>
    <li><a href="{{ route('pet.form.delete') }}">Delete a Pet</a></li>
</ul>
</body>
</html>
