<?php

namespace App\Blog\Table;

use App\Blog\Entity\Post;
use Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;

/**
 * cette sclasse est utilisée pour le mapping objet relation avec la base de
 * donnée encore appelée repository (dao)
 */
class PostTable
{

    /**
     * Undocumented variable
     *
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     *  elle permet d'ffectué la pagination
     * pour les article
     *
     * @param integer $perPage nombre d'éléments par pages
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            'SELECT * FROM posts ORDER BY created_at DESC',
            'SELECT COUNT(id) FROM posts',
            Post::class
        );
        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * recupère un article a partie de son id
     * directement dans la base de donné
     *
     * @param integer $id
     * @return Post/null
     */
    public function find(int $id): ?Post
    {
        $query = $this->pdo->prepare('SELECT *FROM posts WHERE id=?');
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $query->fetch() ?: null;
    }
}
