<?php

namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Router;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
//use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * cette classe définir les différents actions de notre controller blogmodule (module)
 * en utilisant le render interface
 */
class BlogAction
{

    use RouterAwareAction; //permet utiliser ce trait comme sa methode redirect

    /**
     * le renderer
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     * propriete qui va represente une instence de PDO
     *
     * @var [type]
     */
    private $pdo;

    /**
     * elle permet de creer une instence de router
     *
     * @var [type]
     */
    private $router;

    /**
     * propiétée utilisé pour communiquer avec la base de données et joue le role de notre repository(dao)
     *
     * @var PostTable
     */
    private $postTable;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }

    public function __invoke(Request $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        }
        return $this->index($request);
    }

    /**
     * retourne les articles
     *
     * @return String
     */
    public function index(Request $request): String
    {
        $params = $request->getQueryParams();
        $posts = $this->postTable->findPaginated(12, $params['p'] ?? 1);

        return $this->renderer->render('@blog/index', compact('posts'));
    }

    /**
     * Affiche un article et fait une redirection sur l article
     * si le slug est incorrect
     *
     * @param Request $request
     * @return ResposeInterface|string
     */
    public function show(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($request->getAttribute('id'));

        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'slug' => $post->slug,
                'id' => $post->id
            ]);
        }
        return $this->renderer->render('@blog/show', ['post' => $post]);
    }
}
