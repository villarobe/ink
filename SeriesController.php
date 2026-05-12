<?php
/**
 * controllers/SeriesController.php
 * Waves of Ink — Handles all series_* AJAX actions.
 */

class SeriesController
{
    public function __construct(private SeriesModel $seriesModel) {}

    // ── action: series_list ──────────────────────────────────────

    public function list(): never
    {
        $author = clean($_GET['author'] ?? '');

        if ($author !== '' && !in_array($author, ALLOWED_AUTHORS, true)) {
            jsonResponse(false, 'Invalid author selected.');
        }

        $series = $this->seriesModel->findAll($author);
        jsonResponse(true, extra: ['data' => $series]);
    }

    // ── action: series_get ───────────────────────────────────────

    public function get(): never
    {
        $seriesId = (int) ($_GET['id'] ?? 0);

        if (!$seriesId) {
            jsonResponse(false, 'Invalid series ID.');
        }

        $series = $this->seriesModel->findById($seriesId);
        if (!$series) {
            jsonResponse(false, 'Series not found.');
        }

        $books = $this->seriesModel->findBooks($seriesId);
        jsonResponse(true, extra: ['data' => ['series' => $series, 'books' => $books]]);
    }

    // ── action: series_add ──────────────────────────────────────

    public function add(): never
    {
        $author     = clean($_POST['author']      ?? '');
        $seriesName = clean($_POST['series_name'] ?? '');

        if (!in_array($author, ALLOWED_AUTHORS, true)) {
            jsonResponse(false, 'Invalid author selected.');
        }
        if (!validateSeriesName($seriesName)) {
            jsonResponse(false, 'Please enter a valid series name.');
        }
        if ($this->seriesModel->nameExistsForAuthor($author, $seriesName)) {
            jsonResponse(false, 'That series already exists for this author.');
        }

        $newId = $this->seriesModel->create($author, $seriesName);
        jsonResponse(true, 'Series added successfully!', ['id' => $newId]);
    }

    // ── action: series_edit ──────────────────────────────────────

    public function edit(): never
    {
        $seriesId   = (int) ($_POST['id']          ?? 0);
        $author     = clean($_POST['author']        ?? '');
        $seriesName = clean($_POST['series_name']   ?? '');

        if (!$seriesId) {
            jsonResponse(false, 'Invalid series ID.');
        }
        if (!in_array($author, ALLOWED_AUTHORS, true)) {
            jsonResponse(false, 'Invalid author selected.');
        }
        if (!validateSeriesName($seriesName)) {
            jsonResponse(false, 'Please enter a valid series name.');
        }
        if (!$this->seriesModel->findById($seriesId)) {
            jsonResponse(false, 'Series not found.');
        }
        if ($this->seriesModel->nameExistsForAuthor($author, $seriesName, $seriesId)) {
            jsonResponse(false, 'That series name already exists for this author.');
        }

        $this->seriesModel->update($seriesId, $author, $seriesName);
        jsonResponse(true, 'Series updated successfully!');
    }
}
