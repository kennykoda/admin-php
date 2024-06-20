<!DOCTYPE html>
<html>
<head>
    <title>Holding Page</title>
    <script>
        function checkNextForm() {
            fetch('get_next_form.php')
                .then(response => response.json())
                .then(data => {
                    if (data.next_form) {
                        window.location.href = data.next_form;
                    } else {
                        setTimeout(checkNextForm, 3000); // Retry after 3 seconds
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            checkNextForm();
        });
    </script>
</head>
<body>
    <p>Please wait while we process your data...</p>
</body>
</html>
