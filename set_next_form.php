<?php
$user_id = $_POST['user_id'];
$next_form = $_POST['next_form'];

// Add a timestamp to the next form file to make it valid only for a short period
$timestamp = time();
$data = ['form' => $next_form, 'timestamp' => $timestamp];
file_put_contents("data/next_form_{$user_id}.txt", json_encode($data));

header("Location: admin_panel.php");
exit();
?>
