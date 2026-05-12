<?php
/**
 * helpers/utils.php
 * Waves of Ink — Shared utility functions.
 */

/**
 * Trim and sanitize a plain-text input value.
 */
function clean(string $val): string
{
    return trim($val);
}

/**
 * Validate that a series name is non-empty and within the DB column limit.
 */
function validateSeriesName(string $seriesName): bool
{
    return $seriesName !== '' && mb_strlen($seriesName) <= 255;
}

/**
 * Send a JSON response and terminate.
 *
 * @param bool   $success
 * @param string $message  Human-readable status message.
 * @param array  $extra    Any additional keys to merge into the response.
 */
function jsonResponse(bool $success, string $message = '', array $extra = []): never
{
    $payload = ['success' => $success];
    if ($message !== '') {
        $payload['message'] = $message;
    }
    echo json_encode(array_merge($payload, $extra));
    exit;
}
