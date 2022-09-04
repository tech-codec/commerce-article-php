<?php

use Framework\App;
use App\Blog\BlogModule;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Renderer\PHPRenderer;
use Framework\Renderer\TwigRenderer;

require '../vendor/autoload.php';

$renderer = new TwigRenderer(dirname(__DIR__) . '/views');


/*$loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/views');

$twig = new Twig\Environment($loader, []);*/

$app = new App(
    [
        BlogModule::class
    ],
    [
        'renderer' => $renderer
    ]
);

$response = $app->run(ServerRequest::fromGlobals());

\Http\Response\send($response);
