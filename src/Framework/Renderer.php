<?php

namespace Framework;

use phpDocumentor\Reflection\Types\Self_;

class Renderer
{

    const DEFAULT_NAMESPACE = '__MAIN';

    /**
     * le tableau des qui va contenir les chemins des vues
     *
     * @var array
     */
    private $paths = [];


    /**
     * variable globalement accécible pour toute les vues
     *
     * @var array
     */
    private $globals = [];


    /**
     * permet d'ajoutée un chemin pour charger les vues
     *
     * @param string $path
     * @param string|null $namespace
     * @return void
     */
    public function addPath(string $path, ?string $namespace = null): void
    {
        if (is_null($namespace)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $path;
        } else {
            $this->paths[$namespace] = $path;
        }
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
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }

        ob_start();

        $renderer = $this;

        extract($this->globals);

        extract($params);

        require($path);

        return ob_get_clean();
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
        $this->globals[$key] = $value;
    }

    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }


    /**
     * permet de remplace le namespace pa le chemain qui correspon au namespace au niveau de la vue
     * et ainsi retourné le chemain lié a cette vue ainsi que la vue
     *
     * @param string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
