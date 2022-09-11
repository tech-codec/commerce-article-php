<?php

namespace Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


/**
 * cette classe est en charge de d'aujouter le chemin  d'une vue 
 * et de rendre cette vue avec les parramettre correspondants 
 */
class TwigRenderer implements RendererInterface
{


    /**
     * représente une instance de Twig pour le renderer de Twig
     *
     * @var [type]
     */
    private $twig;

    /**
     * reprensente le chemin par défaut ou ce trouve les vues qui non pas de namespace
     *
     * @var [type]
     */
    private $loader;

    public function __construct(FilesystemLoader $loader, Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
    }

    /**
     * permet d'ajoutée un chemin pour charger les vues
     *
     * @param string $path
     * @param string|null $namespace
     * @return void
     */
    public function addPath(string $path, ?string $namespace = null): void
    {
        $this->loader->addPath($path, $namespace);
    }



    /**
     * Permet de retourner une vue et des paramètres s'il elle en posède
     * le chemin peut etre précisé avec des namespaces rajourtés via addPath()
     * $this->render('@blog/view');
     * $this->render('view)
     *
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }


    /**
     * permet de rajouter des variables globales a toute les vues
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
