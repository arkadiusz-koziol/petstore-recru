@include('layouts.default')
<!DOCTYPE html>
<html>
<head>
    <title>Add Pet</title>
</head>
<body>
<h1>Add a New Pet</h1>
<form method="POST" action="{{ route('pet.store') }}">
    @csrf
    <label>Category ID:</label>
    <input type="number" name="category[id]" required>

    <label>Category Name:</label>
    <input type="text" name="category[name]" required>

    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Photo URLs (one per line):</label>
    <textarea name="photoUrls"></textarea>

    <label>Tags (one per line):</label>
    <textarea name="tags"></textarea>

    <label>Status:</label>
    <input type="text" name="status" required>

    <button type="submit">Add Pet</button>
</form>
</body>
</html>
