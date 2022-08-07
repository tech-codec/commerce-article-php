<?php

namespace Test\Framework;

use Framework\App;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\Util\StringUtil;

class AppTest extends TestCase
{

    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET', "/demoslash/");
        $response = $app->run($request);
        $this->assertContains('/demoslash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog()
    {
        $app = new App();

        $request = new ServerRequest('GET', "/blog");

        $response = $app->run($request);

        $this->assertStringContainsStringIgnoringCase('<h1>Bienvenue sur le blog</h1>', $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testError404()
    {
        $app = new App();

        $request = new ServerRequest('GET', "/aze");

        $response = $app->run($request);

        $this->assertStringContainsStringIgnoringCase('<h1>Error 404</h1>', $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}
