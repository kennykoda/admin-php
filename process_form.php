<?php
session_start();
$form_id = $_POST['form_id'];
$data = $_POST;  // Sanitize as necessary

$user_id = session_id();
file_put_contents("data/{$user_id}_{$form_id}.txt", json_encode($data));

// Redirect to holding page
header("Location: holding_page.php");
exit();
?>
