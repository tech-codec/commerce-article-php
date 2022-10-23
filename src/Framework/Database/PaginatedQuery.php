<?php

namespace Framework\Database;

use Pagerfanta\Adapter\AdapterInterface;

/**
 * cette classe permet d'effectué la pagination
 * en communiquant directement avec la base de données
 */
class PaginatedQuery implements AdapterInterface
{

    /**
     * permet de communique avec la base de donnees
     *
     * @var \PDO
     */
    private $pdo;

    /**
     * permet de recupérer les éléments d'une table
     *
     * @var String
     */
    private $query;

    /**
     * permet de recuperer le nombre total d'éléments d'une
     *table
     *
     * @var String
     */
    private $countQuery;

    private $entity;


    /**
     * Undocumented function
     *
     * @param string $entity
     * @param \PDO $pdo
     * @param string $query Requette permettant de recupérer les post
     * @param string $countQuery la requette permettant de recupérer le nombre total de post
     */
    public function __construct(\PDO $pdo, string $query, string $countQuery, string $entity)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
        $this->entity = $entity;
    }

    /**
     * retourne le nombre total d'élément d'une table
     *
     * @return integer
     */
    public function getNbResults(): int
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }


    /**
     * elle permet de définir le nombre délément par page
     * et le nombre de page
     *
     * @param integer $offset
     * @param integer $length
     * @return iterable
     */
    public function getSlice(int $offset, int $length): array
    {
        $statement = $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        $statement->bindParam('offset', $offset, \PDO::PARAM_INT);
        $statement->bindParam('length', $length, \PDO::PARAM_INT);
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        $statement->execute();

        return $statement->fetchAll();
    }
}
