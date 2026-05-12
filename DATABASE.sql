-- ============================================================
--  Waves of Ink - Database Setup
--  Run this in phpMyAdmin or MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS waves_of_ink
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE waves_of_ink;

CREATE TABLE IF NOT EXISTS book_series (
  id            INT(11)       NOT NULL AUTO_INCREMENT,
  author        ENUM('Jonaxx','Inksteady') NOT NULL,
  series_name   VARCHAR(255)  NOT NULL,
  created_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY unique_author_series (author, series_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS books (
  id              INT(11)       NOT NULL AUTO_INCREMENT,
  title           VARCHAR(255)  NOT NULL,
  author          ENUM('Jonaxx','Inksteady') NOT NULL,
  series_id       INT(11)       DEFAULT NULL,
  genre           VARCHAR(100)  NOT NULL,
  description     TEXT          NOT NULL,
  status          ENUM('Ongoing','Completed') NOT NULL DEFAULT 'Ongoing',
  age_rating      VARCHAR(10)   NOT NULL DEFAULT '13+',
  trigger_warning TEXT          DEFAULT NULL,
  book_cover      VARCHAR(255)  DEFAULT NULL,
  created_at      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_books_series_id (series_id),
  CONSTRAINT fk_books_series
    FOREIGN KEY (series_id) REFERENCES book_series(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  Sample seed data (optional - delete if not needed)
-- ============================================================
INSERT INTO book_series (author, series_name) VALUES
('Jonaxx', 'Good Lips Series'),
('Jonaxx', 'University Series'),
('Inksteady', 'Mafia Hearts'),
('Inksteady', 'Fallen Hearts')
ON DUPLICATE KEY UPDATE series_name = VALUES(series_name);

INSERT INTO books (title, author, series_id, genre, description, status, age_rating, trigger_warning, book_cover) VALUES
('Dirty Little Secrets', 'Jonaxx',
 (SELECT id FROM book_series WHERE author = 'Jonaxx' AND series_name = 'Good Lips Series'),
 'Romance / Drama',
 'A gripping story of love, betrayal, and secrets that can tear a family apart. Two souls entangled in a web of lies must decide what matters most.',
 'Completed', '18+',
 'Contains themes of infidelity, emotional manipulation, and strong language.',
 NULL),

('The Bet', 'Jonaxx',
 (SELECT id FROM book_series WHERE author = 'Jonaxx' AND series_name = 'University Series'),
 'Romance / Teen',
 'A classic enemies-to-lovers story set in high school. A popular bad boy makes a bet about the school nerd - but feelings are never part of the plan.',
 'Completed', '16+',
 'Mild language, bullying themes, and emotional distress.',
 NULL),

('Maid for the Mafia', 'Inksteady',
 (SELECT id FROM book_series WHERE author = 'Inksteady' AND series_name = 'Mafia Hearts'),
 'Dark Romance / Thriller',
 'Forced into servitude for a ruthless mafia lord, Aria discovers that monsters can be beautiful - and that beauty can be the most dangerous thing of all.',
 'Ongoing', '18+',
 'Contains violence, coercive situations, dark themes, and explicit content.',
 NULL),

('Broken Halo', 'Inksteady',
 (SELECT id FROM book_series WHERE author = 'Inksteady' AND series_name = 'Fallen Hearts'),
 'Romance / Angst',
 'An angel who fell from grace meets a man who has lost all faith. Their unlikely bond might just save them both - or destroy everything.',
 'Ongoing', '16+',
 'Grief, depression, and discussions of loss.',
 NULL);
