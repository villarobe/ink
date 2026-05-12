<?php
/**
 * config/constants.php
 * Waves of Ink — Global constants and configuration.
 */

define('ALLOWED_AUTHORS',  ['Jonaxx', 'Inksteady']);
define('ALLOWED_STATUSES', ['Ongoing', 'Completed']);
define('ALLOWED_RATINGS',  ['13+', '16+', '18+']);
define('UPLOAD_DIR',       __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE',    2 * 1024 * 1024);           // 2 MB
define('ALLOWED_MIMES',    ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
