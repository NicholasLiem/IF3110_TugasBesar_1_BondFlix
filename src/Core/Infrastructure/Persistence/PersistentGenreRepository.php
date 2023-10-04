<?php

namespace Core\Infrastructure\Persistence;

use Core\Application\Repositories\GenreRepository;
use Core\Domain\Entities\Genre;
use Exception;
use PDO;
use Utils\Logger\Logger;

class PersistentGenreRepository implements GenreRepository
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * @throws Exception
     */
    public function createGenre(Genre $genre): ?Genre
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO genre (
                    genre_name)
                VALUES (:genre_name)");

            $genreName = $genre->getGenreName();
            $stmt->bindParam(':genre_name', $genreName);

            if (!$stmt->execute()) {
                Logger::getInstance()->logMessage('Genre creation failed');
                throw new Exception("Genre creation failed");
            }

            $genre->setGenreId($this->getGenreIdByName($genreName)->getGenreId());
            return $genre;
        } catch (Exception $e) {
            Logger::getInstance()->logMessage('User creation failed: ' . $e->getMessage());
            throw new Exception("User creation failed");
        }
    }

    public function getGenreById(int $genre_id): ?Genre
    {
        try {
            $stmt = $this->db->prepare("SELECT genre_id FROM genre WHERE genre_id = :genre_id");
            $stmt->bindParam(':genre_id', $genre_id);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                Logger::getInstance()->logMessage('Genre fetch failed, id not found');
                throw new Exception("Genre fetch failed");
            }

            return new Genre($genre_id, $result['genre_name']);
        } catch (Exception $e) {
            Logger::getInstance()->logMessage('Error while fetching genre by name: ' . $e->getMessage());
            throw new Exception("Error while fetching genre by name");
        };
    }

    /**
     * @throws Exception
     */
    public function getGenreIdByName(string $genre_name) : ?Genre
    {
        try {
            $stmt = $this->db->prepare("SELECT genre_id FROM genre WHERE genre_name = :genre_name");
            $stmt->bindParam(':genre_name', $genre_name);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                Logger::getInstance()->logMessage('Genre fetch failed, no registered genre');
                throw new Exception("Genre fetch failed");
            }

            return new Genre($result['genre_id'], $genre_name);
        } catch (Exception $e) {
            Logger::getInstance()->logMessage('Error while fetching genre by name: ' . $e->getMessage());
            throw new Exception("Error while fetching genre by name");
        }
    }

    public function updateGenre(Genre $genre): ?Genre
    {
        $stmt = $this->db->prepare("
            UPDATE genre SET 
                genre_name = :new_genre_name
            WHERE genre_id = :genre_id"
        );

        $newGenreName = $genre->getGenreName();

        $stmt->bindParam(':new_genre_name', $newGenreName);

        if (!$stmt->execute()) {
            throw new Exception("User update failed");
        }

        return $genre;

    }

    public function deleteGenreById(int $genre_id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM genre
            WHERE genre_id = :genre_id
        ");

        $stmt->bindParam(':genre_id', $genre_id);

        if (!$stmt->execute()) {
            throw new Exception("Genre deletion failed");
        }
        return true;
    }

    public function getAllGenre(): array {
        try {
            $stmt = $this->db->prepare("
                SELECT genre_id, genre_name
                FROM genre
                ORDER BY genre_id ASC;
            ");

            if (!$stmt->execute()) {
                throw new Exception("Database error while fetching genre data");
            }

            $genres = [];
            while ($genreData = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $genre = new Genre(
                    (int) $genreData['genre_id'],
                    $genreData['genre_name'],
                );

                $genres[] = $genre;
            }

            return $genres;
        } catch (Exception $e) {
            Logger::getInstance()->logMessage('Failed to fetch all users: ' . $e->getMessage());
            throw new Exception("Failed to fetch all users");
        }
    }
}