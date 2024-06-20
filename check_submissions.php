<?php
session_start();
$data_dir = 'data/';
$new_submission = false;

if (is_dir($data_dir)) {
    $files = glob($data_dir . '*.txt');
    $last_checked = isset($_GET['last_checked']) ? intval($_GET['last_checked']) / 1000 : 0;
    foreach ($files as $file) {
        // Skip files that store next form information
        if (strpos(basename($file), 'next_form_') === 0) {
            continue;
        }

        // Check for files created or modified after the last checked time
        if (filemtime($file) > $last_checked) {
            $new_submission = true;
            break;
        }
    }
}

echo json_encode(['new_submission' => $new_submission]);
?>
