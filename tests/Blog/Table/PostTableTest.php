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

    public function testUpdate()
    {
        $this->seedDatabase();
        $this->postTable->update(1, ['name' => 'salut', 'slug' => 'demo']);
        $post = $this->postTable->find(1);
        $this->assertEquals('salut', $post->name);
        $this->assertEquals('demo', $post->slug);
    }

    public function testInsert()
    {
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'content' => "bonjour le monde"]);
        $post = $this->postTable->find(1);
        $this->assertEquals("Salut", $post->name);
        $this->assertEmpty('demo', $post->slug);
        $this->assertEmpty('bonjour le monde', $post->content);
    }

    public function testDelete()
    {
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'content' => "bonjour le monde"]);
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'content' => "bonjour le monde"]);
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        $this->assertEquals(2, (int) $count);
        $this->postTable->delete($this->pdo->lastInsertId());
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        $this->assertEquals(1, (int) $count);
    }
}
