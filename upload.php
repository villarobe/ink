<?php
/**
 * helpers/upload.php
 * Waves of Ink — Book-cover file upload handler.
 */

/**
 * Validate and move an uploaded file.
 *
 * Checks for upload errors, file size, and real MIME type (via finfo).
 * Returns a randomised filename on success, or false on any failure.
 *
 * @param array  $file         Entry from $_FILES (e.g. $_FILES['book_cover']).
 * @param string $uploadDir    Absolute path to the destination directory.
 * @param array  $allowedMimes Permitted MIME types (e.g. ['image/jpeg', 'image/png']).
 * @param int    $maxSize      Maximum allowed file size in bytes.
 *
 * @return string|false  Stored filename on success, false on failure.
 */
function handleUpload(array $file, string $uploadDir, array $allowedMimes, int $maxSize): string|false
{
    // 1. PHP upload error check
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    // 2. File-size guard
    if ($file['size'] > $maxSize) {
        return false;
    }

    // 3. Real MIME type via finfo (not the browser-supplied header)
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, $allowedMimes, true)) {
        return false;
    }

    // 4. Build a collision-proof filename and move the file
    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $dest     = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return false;
    }

    return $filename;
}
