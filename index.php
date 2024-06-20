<!DOCTYPE html>
<html>
<head>
    <title>Form 1</title>
</head>
<body>
    <h1>Form 1</h1>
    <form action="process_form.php" method="post">
        <input type="hidden" name="form_id" value="form1">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
