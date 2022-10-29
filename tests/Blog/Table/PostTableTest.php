<?php

namespace Tests\App\Blog\Table;

use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use Tests\DatabaseTestCase;

/**
 * cette classe permet de tester la table post
 * donct ses différentes requettes
 */
class PostTableTest extends DatabaseTestCase
{
    private PostTable $postTable;

    public function setup(): void
    {
        parent::setUp();
        $this->postTable = new PostTable($this->pdo);
    }




    public function testFind()
    {
        $this->seedDatabase();
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
    }

    public function testFindNotFoundRecord()
    {
        $post = $this->postTable->find(1);
        $this->assertNull($post);
    }
}
