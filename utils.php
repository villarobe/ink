<?php

function clean(string $val): string
{
    return trim($val);
}


function validateSeriesName(string $seriesName): bool
{
    return $seriesName !== '' && mb_strlen($seriesName) <= 255;
}

function jsonResponse(bool $success, string $message = '', array $extra = []): never
{
    $payload = ['success' => $success];
    if ($message !== '') {
        $payload['message'] = $message;
    }
    echo json_encode(array_merge($payload, $extra));
    exit;
}
