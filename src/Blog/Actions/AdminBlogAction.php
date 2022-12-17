<?php

namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Router;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Sessions\FlashService;
use Framework\Sessions\SessionInterface;
use Framework\validator;
//use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function DI\string;

/**
 * cette classe définir les différents actions de notre controller blogmodule (module)
 * en utilisant le render interface
 */
class AdminBlogAction
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

    /**
     * proprietee de session
     *
     * @var FlashService
     */
    private $flash;

    public function __construct(
        RendererInterface $renderer,
        Router $router,
        PostTable $postTable,
        FlashService $flash
    ) {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
        $this->flash = $flash;
    }

    public function __invoke(Request $request)
    {

        if ($request->getMethod() === 'DELETE') {
            return $this->delete($request);
        }
        if (substr((string)$request->getUri(), -3) === 'new') {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
            return $this->edit($request);
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
        $items = $this->postTable->findPaginated(12, $params['p'] ?? 1);
        return $this->renderer->render('@blog/admin/index', compact('items'));
    }

    /**
     * Editer un article
     *
     * @param Request $request
     * @return ResponseInterface/string
     */
    public function edit(Request $request)
    {
        $item = $this->postTable->find($request->getAttribute('id'));
        $errors = null;
        if ($request->getMethod() === 'POST') {
            $params = $this->getparams($request);
            $params['updated_at'] = date('y-m-d H:i:s');
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->postTable->update($item->id, $params);
                $this->flash->success('L\'article a bien été modifié');
                return $this->redirect('blog.admin.index');
            }

            $errors = $validator->getErrors();
            $params['id'] = $item->id;
            $item = $params;
        }

        return $this->renderer->render('@blog/admin/edit', compact('item', 'errors'));
    }


    /**
     * Creer un article
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params = array_merge($params, [
                'updated_at' => date('y-m-d H:i:s'),
                'created_at' => date('y-m-d H:i:s'),
            ]);
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->postTable->insert($params);
                $this->flash->success('L\'article a bien été modifié');
                return $this->redirect('blog.admin.index');
            }
            $errors = $validator->getErrors();
            $item = $params;
        }

        return $this->renderer->render('@blog/admin/create', compact('item', 'errors'));
    }

    public function delete(Request $request)
    {
        $this->postTable->delete($request->getAttribute('id'));
        return $this->redirect('blog.admin.index');
    }

    private function getParams(Request $request)
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'slug', 'content']);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function getValidator(Request $request)
    {
        return (new validator($request->getParsedBody()))
            ->required('content', 'name', 'slug')
            ->length('content', 10)
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->slug('slug');
    }
}
