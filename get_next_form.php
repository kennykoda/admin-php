<?php
session_start();
$user_id = session_id();
$next_form = null;

if (file_exists("data/next_form_{$user_id}.txt")) {
    $data = json_decode(file_get_contents("data/next_form_{$user_id}.txt"), true);
    $timestamp = $data['timestamp'];
    
    // Check if the next form decision is still valid (within 5 minutes, i.e., 300 seconds)
    if (time() - $timestamp <= 30) {
        $next_form = $data['form'];
    }
    
    // Reset the next form decision
    unlink("data/next_form_{$user_id}.txt");
}

echo json_encode(['next_form' => $next_form]);
?>
