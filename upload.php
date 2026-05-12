<?php

function handleUpload(array $file, string $uploadDir, array $allowedMimes, int $maxSize): string|false
{
  
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

   
    if ($file['size'] > $maxSize) {
        return false;
    }

   
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, $allowedMimes, true)) {
        return false;
    }

   
    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $dest     = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return false;
    }

    return $filename;
}
