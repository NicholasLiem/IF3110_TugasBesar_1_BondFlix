<?php

namespace Core\Application\Services;

use Exception;
use Core\Domain\Entities\Genre;
use Core\Infrastructure\Persistence\PersistentGenreRepository;

class GenreService
{
    private PersistentGenreRepository $genreRepository;

    public function __construct($genreRepository) {
        $this->genreRepository = $genreRepository;
    }
    public function getAllGenre(): array {
        return $this->genreRepository->getAllGenre();
    }

    public function getGenreById(int $id): ?Genre {
        return $this->genreRepository->getGenreById($id);
    }
    public function removeGenre(int $id): void {
        $this->genreRepository->deleteGenreById($id);
    }

    /**
     * @throws Exception
     */
    public function addGenre(string $genre_name): ?Genre {
        $newGenre = new Genre();
        $newGenre->setGenreName($genre_name);
        return $this->genreRepository->createGenre($newGenre);
    }

    public function updateGenre($genre_id, $genre_name): ?Genre {
        $genre = $this->genreRepository->getGenreById($genre_id);
        $genre->setGenreName($genre_name);
        return $this->genreRepository->updateGenre($genre);
    }
}