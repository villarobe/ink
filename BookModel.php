<?php
/**
 * models/BookModel.php
 * Waves of Ink — Data-access layer for the books table.
 */

class BookModel
{
    public function __construct(private PDO $pdo) {}

    // ── Read ─────────────────────────────────────────────────────

    /**
     * Return all books joined with their series name, oldest first.
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT b.*, s.series_name
             FROM books b
             LEFT JOIN book_series s ON s.id = b.series_id
             ORDER BY b.created_at ASC'
        );
        return $stmt->fetchAll();
    }

    /**
     * Return a single book row (with series_name), or false.
     */
    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare(
            'SELECT b.*, s.series_name
             FROM books b
             LEFT JOIN book_series s ON s.id = b.series_id
             WHERE b.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Return only the book_cover filename for a given book ID, or false.
     */
    public function findCoverById(int $id): string|false
    {
        $stmt = $this->pdo->prepare(
            'SELECT book_cover FROM books WHERE id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? (string) $row['book_cover'] : false;
    }

 
    public function create(
        string  $title,
        string  $author,
        int     $seriesId,
        string  $genre,
        string  $desc,
        string  $status,
        string  $rating,
        ?string $trigger,
        ?string $cover
    ): int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO books
             (title, author, series_id, genre, description, status, age_rating, trigger_warning, book_cover)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$title, $author, $seriesId, $genre, $desc, $status, $rating, $trigger, $cover]);
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Update an existing book record.
     */
    public function update(
        int     $id,
        string  $title,
        string  $author,
        int     $seriesId,
        string  $genre,
        string  $desc,
        string  $status,
        string  $rating,
        ?string $trigger,
        ?string $cover
    ): void {
        $stmt = $this->pdo->prepare(
            'UPDATE books
             SET title=?, author=?, series_id=?, genre=?, description=?,
                 status=?, age_rating=?, trigger_warning=?, book_cover=?
             WHERE id=?'
        );
        $stmt->execute([$title, $author, $seriesId, $genre, $desc, $status, $rating, $trigger, $cover, $id]);
    }

    /**
     * Delete a book record by ID.
     */
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM books WHERE id = ?');
        $stmt->execute([$id]);
    }
}
