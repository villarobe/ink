<?php

function ensureLibrarySchema(PDO $pdo): void
{
    static $ready = false;
    if ($ready) {
        return;
    }

    // ── 1. book_series table ─────────────────────────────────────
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS book_series (
            id         INT(11)                      NOT NULL AUTO_INCREMENT,
            author     ENUM('Jonaxx','Inksteady')   NOT NULL,
            series_name VARCHAR(255)                NOT NULL,
            created_at TIMESTAMP                    NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_author_series (author, series_name)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    // ── 2. Add series_id column to books (idempotent) ────────────
    $seriesIdExists = (bool) $pdo
        ->query("SHOW COLUMNS FROM books LIKE 'series_id'")
        ->fetch();

    if (!$seriesIdExists) {
        $pdo->exec(
            "ALTER TABLE books
             ADD COLUMN series_id INT(11) DEFAULT NULL AFTER author"
        );
    }

    // ── 3. Add FK (idempotent) ───────────────────────────────────
    $fkExists = (bool) $pdo->query("
        SELECT CONSTRAINT_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME   = 'books'
          AND COLUMN_NAME  = 'series_id'
          AND REFERENCED_TABLE_NAME = 'book_series'
        LIMIT 1
    ")->fetch();

    if (!$fkExists) {
        $pdo->exec(
            "ALTER TABLE books
             ADD CONSTRAINT fk_books_series
             FOREIGN KEY (series_id) REFERENCES book_series(id)
             ON DELETE SET NULL"
        );
    }

    // ── 4. Seed "Standalone" series for each author ──────────────
    $pdo->exec("
        INSERT IGNORE INTO book_series (author, series_name)
        SELECT DISTINCT author, 'Standalone'
        FROM books
    ");

    // ── 5. Assign un-bucketed books to their Standalone series ───
    $pdo->exec("
        UPDATE books b
        JOIN book_series s
          ON s.author      = b.author
         AND s.series_name = 'Standalone'
        SET b.series_id = s.id
        WHERE b.series_id IS NULL
    ");

    $ready = true;
}
