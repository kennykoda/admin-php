<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #343a40;
        }
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 1.2em;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .form-data {
            padding: 20px;
            border-radius: 10px;
            white-space: pre-wrap;
            font-family: monospace;
            font-weight: bold;
            font-size: 1.4em;
        }
        @keyframes glow {
            0% {
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }
            100% {
                box-shadow: 0 0 20px rgba(0, 123, 255, 0.5);
            }
        }
        .inner-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .inner-table th, .inner-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 1em;
        }
        .inner-table th {
            background-color: #f2f2f2;
            font-weight: normal;
        }
        .inner-table td {
            font-family: Arial, sans-serif;
            font-size: 0.9em;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons form {
            display: inline;
        }
        .action-buttons button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: .8em;
            font-weight: bold;
        }
        .action-buttons button:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        let lastCheckedTime = 0;

        // Function to check for new submissions
        function checkNewSubmissions() {
            fetch('check_submissions.php?last_checked=' + lastCheckedTime)
                .then(response => response.json())
                .then(data => {
                    if (data.new_submission) {
                        document.getElementById('alertSound').play();
                        alert('New form submission received!');
                        window.location.reload();
                    } else {
                        setTimeout(checkNewSubmissions, 3000); // Retry after 3 seconds
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            lastCheckedTime = Date.now();
            checkNewSubmissions();
        });
    </script>
</head>
<body>
    <h1>Admin Panel</h1>
    <audio id="alertSound" src="alert_sound.mp3"></audio>
    <?php
    // Check if the data directory exists
    $data_dir = 'data/';
    if (!is_dir($data_dir)) {
        echo "<p>Data directory not found.</p>";
    } else {
        $files = glob($data_dir . '*.txt');
        if (empty($files)) {
            echo "<p>No form data available.</p>";
        } else {
            echo '<table>';
            echo '<tr><th>Form ID</th><th>Form Data</th><th>Action</th></tr>';
            foreach ($files as $file) {
                // Skip files that store next form information
                if (strpos(basename($file), 'next_form_') === 0) {
                    continue;
                }

                $data = json_decode(file_get_contents($file), true);
                if ($data === null) {
                    echo "<p>Error reading data from $file</p>";
                    continue;
                }

                $user_id = explode('_', basename($file, '.txt'))[0];

                // Display form data in a table row
                echo '<tr>';
                echo '<td>' . htmlspecialchars($data['form_id']) . '</td>';
                echo '<td class="form-data">';
                echo '<table class="inner-table">';
                echo '<tr><th>Field</th><th>Value</th></tr>';
                foreach ($data as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($key) . '</td>';
                    echo '<td>' . htmlspecialchars(json_encode($value)) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</td>';
                echo '<td class="action-buttons">';
                echo '<form action="set_next_form.php" method="post">';
                echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">';
                echo '<input type="hidden" name="current_form" value="' . htmlspecialchars($data['form_id']) . '">';
                if ($data['form_id'] !== 'form1') {
                    echo '<input type="hidden" name="next_form" value="form1.php">';
                    echo '<button type="submit">Form 1</button>';
                }
                echo '</form>';
                echo '<form action="set_next_form.php" method="post">';
                echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">';
                echo '<input type="hidden" name="current_form" value="' . htmlspecialchars($data['form_id']) . '">';
                if ($data['form_id'] !== 'form2') {
                    echo '<input type="hidden" name="next_form" value="form2.php">';
                    echo '<button type="submit">Form 2</button>';
                }
                echo '</form>';
                echo '<form action="set_next_form.php" method="post">';
                echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">';
                echo '<input type="hidden" name="current_form" value="' . htmlspecialchars($data['form_id']) . '">';
                if ($data['form_id'] !== 'form3') {
                    echo '<input type="hidden" name="next_form" value="form3.php">';
                    echo '<button type="submit">Form 3</button>';
                }
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
    ?>
</body>
</html>
