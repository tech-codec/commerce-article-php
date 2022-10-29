<?php

namespace Tests;

use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * cette classe a pour role de tester nos table qui comminique avec la base 
 * de nonnées afin de tester les rquettes sql
 */
class DatabaseTestCase extends TestCase
{

    /**
     * element de connexion a la bd
     *
     * @var \PDO
     */
    protected \PDO $pdo;

    protected $seed = true;

    private Manager $manager;

    /**
     * elle a pour role d'utiliser phinx 
     * pour generer une base de données memoire
     * qui vas nous pernmettre de tester les différentes 
     * requettes de nos repository
     *
     * @return void
     */
    public function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);


        //on creet un environnement de test et on lit a la meme instance de pdo
        $configArray = require('phinx.php');
        $configArray['environments']['test'] = [
            'adapter' => 'sqlite',
            'connection' => $pdo
        ];
        $config = new Config($configArray);
        $manager = new Manager($config, new StringInput(' '), new NullOutput());
        $manager->migrate('test');
        $this->manager = $manager;
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->pdo = $pdo;
    }


    public function seedDatabase()
    {
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);
        $this->manager->seed('test');
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
}
