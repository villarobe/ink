<?php

class SeriesModel
{
    public function __construct(private PDO $pdo) {}

  
    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, author, series_name
             FROM book_series
             WHERE id = ?
             LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findAll(string $author = ''): array
    {
        if ($author !== '') {
            $stmt = $this->pdo->prepare(
                'SELECT id, author, series_name
                 FROM book_series
                 WHERE author = ?
                 ORDER BY series_name ASC'
            );
            $stmt->execute([$author]);
        } else {
            $stmt = $this->pdo->query(
                'SELECT id, author, series_name
                 FROM book_series
                 ORDER BY author ASC, series_name ASC'
            );
        }
        return $stmt->fetchAll();
    }

 
    public function findBooks(int $seriesId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT b.*, s.series_name
             FROM books b
             LEFT JOIN book_series s ON s.id = b.series_id
             WHERE b.series_id = ?
             ORDER BY b.title ASC'
        );
        $stmt->execute([$seriesId]);
        return $stmt->fetchAll();
    }

   
    public function findIdByAuthorAndName(string $author, string $seriesName): ?int
    {
        $stmt = $this->pdo->prepare(
            'SELECT id
             FROM book_series
             WHERE author = ? AND series_name = ?
             LIMIT 1'
        );
        $stmt->execute([$author, $seriesName]);
        $id = $stmt->fetchColumn();
        return $id !== false ? (int) $id : null;
    }

   
    public function validateIdForAuthor(int $id, string $author): ?int
    {
        $stmt = $this->pdo->prepare(
            'SELECT id
             FROM book_series
             WHERE id = ? AND author = ?
             LIMIT 1'
        );
        $stmt->execute([$id, $author]);
        $found = $stmt->fetchColumn();
        return $found !== false ? (int) $found : null;
    }

    public function create(string $author, string $seriesName): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO book_series (author, series_name) VALUES (?, ?)'
        );
        $stmt->execute([$author, $seriesName]);
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Update an existing series row.
     */
    public function update(int $id, string $author, string $seriesName): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE book_series SET author = ?, series_name = ? WHERE id = ?'
        );
        $stmt->execute([$author, $seriesName, $id]);
    }

    
    public function nameExistsForAuthor(string $author, string $seriesName, int $excludeId = 0): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT id
             FROM book_series
             WHERE author = ? AND series_name = ? AND id <> ?
             LIMIT 1'
        );
        $stmt->execute([$author, $seriesName, $excludeId]);
        return (bool) $stmt->fetchColumn();
    }

   
    public function findOrCreate(string $author, string $seriesIdRaw, string $newSeriesRaw): ?int
    {
        $newSeries = trim($newSeriesRaw);

        if ($newSeries !== '') {
            if (!validateSeriesName($newSeries)) {
                return null;
            }
            $existing = $this->findIdByAuthorAndName($author, $newSeries);
            return $existing ?? $this->create($author, $newSeries);
        }

        $seriesId = (int) $seriesIdRaw;
        if ($seriesId > 0) {
            return $this->validateIdForAuthor($seriesId, $author);
        }

        return null;
    }
}
