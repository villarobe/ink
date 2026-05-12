<?php

class BookController
{
    public function __construct(
        private BookModel   $bookModel,
        private SeriesModel $seriesModel
    ) {}

    // ── action: list ─────────────────────────────────────────────

    public function list(): never
    {
        $books = $this->bookModel->findAll();
        jsonResponse(true, extra: ['data' => $books]);
    }

    // ── action: get ──────────────────────────────────────────────

    public function get(): never
    {
        $id   = (int) ($_GET['id'] ?? 0);
        $book = $this->bookModel->findById($id);

        $book
            ? jsonResponse(true, extra: ['data' => $book])
            : jsonResponse(false, 'Book not found.');
    }

    // ── action: add ──────────────────────────────────────────────

    public function add(): never
    {
        [$title, $author, $genre, $desc, $status, $rating, $trigger] = $this->extractBookFields();

        if (!$title || !$author || !$genre || !$desc) {
            jsonResponse(false, 'Please fill in all required fields.');
        }
        
        if (!in_array($author, ALLOWED_AUTHORS, true)) {
            jsonResponse(false, 'Invalid author selected.');
        }
        if (!in_array($status, ALLOWED_STATUSES, true)) {
            jsonResponse(false, 'Invalid status.');
        }
        if (!in_array($rating, ALLOWED_RATINGS, true)) {
            jsonResponse(false, 'Invalid age rating.');
        }

        
        $seriesId = $this->seriesModel->findOrCreate(
            $author,
            clean($_POST['series_id'] ?? ''),
            $_POST['new_series_name'] ?? ''
        );
        if (!$seriesId) {
            jsonResponse(false, 'Please select or create a series for this author.');
        }

        // Handle optional cover upload
        $cover = $this->resolveUpload();

        $newId = $this->bookModel->create($title, $author, $seriesId, $genre, $desc, $status, $rating, $trigger ?: null, $cover);
        jsonResponse(true, 'Book added successfully!', ['id' => $newId]);
    }

    // ── action: edit ─────────────────────────────────────────────

    public function edit(): never
    {
        $id = (int) ($_POST['id'] ?? 0);
        [$title, $author, $genre, $desc, $status, $rating, $trigger] = $this->extractBookFields();

        if (!$id || !$title || !$author || !$genre || !$desc) {
            jsonResponse(false, 'Missing required fields.');
        }
        if (!in_array($author,  ALLOWED_AUTHORS,  true) ||
            !in_array($status,  ALLOWED_STATUSES, true) ||
            !in_array($rating,  ALLOWED_RATINGS,  true)) {
            jsonResponse(false, 'Invalid field values.');
        }

        $seriesId = $this->seriesModel->findOrCreate(
            $author,
            clean($_POST['series_id'] ?? ''),
            $_POST['new_series_name'] ?? ''
        );
        if (!$seriesId) {
            jsonResponse(false, 'Please select or create a series for this author.');
        }

        // Verify book exists and get the current cover
        $existingCover = $this->bookModel->findCoverById($id);
        if ($existingCover === false) {
            jsonResponse(false, 'Book not found.');
        }

        // Replace cover only when a new file is submitted
        $cover = $existingCover;
        if (!empty($_FILES['book_cover']['name'])) {
            $newCover = handleUpload($_FILES['book_cover'], UPLOAD_DIR, ALLOWED_MIMES, MAX_FILE_SIZE);
            if ($newCover === false) {
                jsonResponse(false, 'Invalid or oversized image.');
            }
            // Delete the old cover file from disk
            if ($existingCover && file_exists(UPLOAD_DIR . $existingCover)) {
                @unlink(UPLOAD_DIR . $existingCover);
            }
            $cover = $newCover;
        }

        $this->bookModel->update($id, $title, $author, $seriesId, $genre, $desc, $status, $rating, $trigger ?: null, $cover);
        jsonResponse(true, 'Book updated successfully!');
    }

    // ── action: delete ───────────────────────────────────────────

    public function delete(): never
    {
        $id = (int) ($_POST['id'] ?? 0);

        if (!$id) {
            jsonResponse(false, 'Invalid book ID.');
        }

        $cover = $this->bookModel->findCoverById($id);
        if ($cover === false) {
            jsonResponse(false, 'Book not found.');
        }

        // Delete cover from disk before removing the DB record
        if ($cover && file_exists(UPLOAD_DIR . $cover)) {
            @unlink(UPLOAD_DIR . $cover);
        }

        $this->bookModel->delete($id);
        jsonResponse(true, 'Book deleted.');
    }

    // ── Private helpers ──────────────────────────────────────────

    /**
     * Pull and clean the common book fields from $_POST.
     * Returns [title, author, genre, desc, status, rating, trigger].
     */
    private function extractBookFields(): array
    {
        return [
            clean($_POST['title']           ?? ''),
            clean($_POST['author']          ?? ''),
            clean($_POST['genre']           ?? ''),
            clean($_POST['description']     ?? ''),
            clean($_POST['status']          ?? ''),
            clean($_POST['age_rating']      ?? ''),
            clean($_POST['trigger_warning'] ?? ''),
        ];
    }

    /**
     * Attempt to handle an uploaded cover file.
     * Returns the stored filename, or null if no file was submitted.
     * Calls jsonResponse() and exits on upload error.
     */
    private function resolveUpload(): ?string
    {
        if (empty($_FILES['book_cover']['name'])) {
            return null;
        }

        $filename = handleUpload($_FILES['book_cover'], UPLOAD_DIR, ALLOWED_MIMES, MAX_FILE_SIZE);
        if ($filename === false) {
            jsonResponse(false, 'Invalid or oversized image. Use JPG/PNG/WEBP under 2 MB.');
        }

        return $filename;
    }
}
