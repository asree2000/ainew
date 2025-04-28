<?php
if ($_FILES['contractFile']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['contractFile']['name']);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }

    if (move_uploaded_file($_FILES['contractFile']['tmp_name'], $uploadFile)) {
        echo "File successfully uploaded.";
    } else {
        echo "Upload failed.";
    }
} else {
    echo "File upload error.";
}
?>
