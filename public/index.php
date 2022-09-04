<?php

use Framework\App;
use App\Blog\BlogModule;
use Framework\Renderer;
use GuzzleHttp\Psr7\ServerRequest;

require '../vendor/autoload.php';

$renderer = new Renderer();

$renderer->addPath(dirname(__DIR__) . '/views');

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
