@include('layouts.default')
<!DOCTYPE html>
<html>
<head>
    <title>Delete Pet</title>
</head>
<body>
<h1>Delete a Pet</h1>
<form method="POST" id="deletePetForm">
    @csrf
    @method('DELETE')

    <label>Pet ID:</label>
    <input type="number" id="petIdInput" name="petId" required>

    <button type="submit">Delete Pet</button>
</form>

<script>
    document.getElementById('deletePetForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const petId = document.getElementById('petIdInput').value;
        if (!petId) {
            alert('Please enter a valid Pet ID.');
            return;
        }

        this.action = `/pet/${petId}`;
        this.submit();
    });
</script>
</body>
</html>
