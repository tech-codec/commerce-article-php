<?php

/**
 * c'est ce fichier qui est le bootstrap de notre application 
 * c'est a parti d'elle que notre classe App est intenciée
 * pour le lancement de nos controlleurs (module)
 */

use Framework\App;
use App\Blog\BlogModule;
use DI\ContainerBuilder;
use Framework\Renderer\RendererInterface;
use GuzzleHttp\Psr7\ServerRequest;


require '../vendor/autoload.php';

$modules =  [
    BlogModule::class
];

//ici nous définisons le container d'injecteur de dépenpende de PHP DI
// pour la gestion de nos dépendence et les dépendences se trouve dans
//fichier /config/config.php
$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');
foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$builder->addDefinitions(dirname(__DIR__) . '/config.php');
$container = $builder->build();

/*$loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/views');

$twig = new Twig\Environment($loader, []);*/

$app = new App($container, $modules);

$response = $app->run(ServerRequest::fromGlobals());

\Http\Response\send($response);
