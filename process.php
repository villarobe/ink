<?php

session_start();

// ── Bootstrap ────────────────────────────────────────────────────
require_once __DIR__ . '/db_connection.php';
require_once __DIR__ . '/constants.php';
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/upload.php';
require_once __DIR__ . '/schema.php';
require_once __DIR__ . '/BookModel.php';
require_once __DIR__ . '/SeriesModel.php';
require_once __DIR__ . '/BookController.php';
require_once __DIR__ . '/SeriesController.php';

header('Content-Type: application/json');

$db = getDB();
ensureLibrarySchema($db);

// ── Instantiate models & controllers ─────────────────────────────
$seriesModel      = new SeriesModel($db);
$bookModel        = new BookModel($db);
$bookController   = new BookController($bookModel, $seriesModel);
$seriesController = new SeriesController($seriesModel);

// ── Route ─────────────────────────────────────────────────────────
$action = $_POST['action'] ?? $_GET['action'] ?? '';

match ($action) {
    // Book actions
    'list'   => $bookController->list(),
    'get'    => $bookController->get(),
    'add'    => $bookController->add(),
    'edit'   => $bookController->edit(),
    'delete' => $bookController->delete(),

    // Series actions
    'series_list' => $seriesController->list(),
    'series_get'  => $seriesController->get(),
    'series_add'  => $seriesController->add(),
    'series_edit' => $seriesController->edit(),

    // Unknown action
    default => (function () {
        http_response_code(400);
        jsonResponse(false, 'Unknown action.');
    })(),
};
