<?php

/**
 * fichier de configuration propre au blog module
 * pour DEFINIR la valeur du chemin de la route (valeur/blog) du $prefix
 */

use App\Blog\BlogModule;
use function \DI\autowire;
use function \DI\get;

return [
    'blog.prefix' => '/blog',
    //BlogModule::class => autowire()->constructorParameter('prefix', get('blog.prefix'))
];
