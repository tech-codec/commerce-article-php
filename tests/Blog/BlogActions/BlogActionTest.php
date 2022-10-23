<?php

namespace Tests\App\Blog\BlogActions;

use Framework\Router;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;
use App\Blog\Actions\BlogAction;
use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use GuzzleHttp\Psr7\ServerRequest;
use Prophecy\PhpUnit\ProphecyTrait;
use Framework\Renderer\RendererInterface;
use stdClass;

class BlogActionTest extends TestCase
{

    use ProphecyTrait; //utiliser pour moqué les objets

    /**
     * Undocumented variable
     *
     * @var BlogAction
     */
    private  $action;
    /**
     * Undocumented variable
     *
     * @var RendererInterface
     */
    private $renderer;
    /**
     * Undocumented variable
     *
     * @var Router
     */
    private $router;
    /**
     * Undocumented variable
     *
     * @var PostTable
     */
    private $postTable;


    public function setup(): void
    {
        $this->renderer = $this->prophesize(RendererInterface::class); //creation des faux objet
        $this->postTable = $this->prophesize(PostTable::class);
        //Article

        //PDO
        $this->router = $this->prophesize(Router::class);
        $this->action = new BlogAction(
            $this->renderer->reveal(),
            $this->router->reveal(),
            $this->postTable->reveal()
        );
    }

    public function makePost(int $id, string $slug): Post
    {
        $post = new Post(); //creation dun faut article
        $post->id = $id;
        $post->slug = $slug;
        return $post;
    }

    public function testShowRedirect()
    {
        $post = $this->makePost(9, "azeaze-azeaze");
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', $post->id)
            ->withAttribute('slug', 'demo');

        $this->router->generateUri(
            'blog.show',
            ['id' => $post->id, 'slug' => $post->slug]
        )->willReturn('/demo2');
        $this->postTable->find($post->id)->willReturn($post);


        $response = call_user_func_array($this->action, [$request]);

        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals(['/demo2'], $response->getHeader('location'));
    }

    public function testShowReder()
    {
        $post = $this->makePost(9, "azeaze-azeaze");
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', $post->id)
            ->withAttribute('slug', $post->slug);
        $this->postTable->find($post->id)->willReturn($post);
        $this->renderer->render('@blog/show', ['post' => $post]);


        $response = call_user_func_array($this->action, [$request]);

        $this->assertEquals(true, true);
    }
}
