<?php

namespace Framework\Renderer;

interface RendererInterface
{



    /**
     * permet d'ajoutée un chemin pour charger les vues
     *
     * @param string $path
     * @param string|null $namespace
     * @return void
     */
    public function addPath(string $path, ?string $namespace = null): void;



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
    public function render(string $view, array $params = []): string;


    /**
     * permet de rajouter des variables globales a toute les vues
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addGlobal(string $key, $value): void;
}
