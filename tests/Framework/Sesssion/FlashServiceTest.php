<?php

namespace Tests\Framework\session;

use Framework\Sessions\ArraySession;
use Framework\Sessions\FlashService;
use PHPUnit\Framework\TestCase;

class FlashServiceTest extends TestCase
{
    private $session;
    private $flashService;

    public function setup(): void
    {

        $this->session = new ArraySession();
        $this->flashService = new FlashService($this->session);
    }

    public function testDeleteFlashAfterGettingIt()
    {
        $this->flashService->success('Bravo');
        $this->assertEquals('Bravo', $this->flashService->get('success'));
        $this->assertNull($this->session->get('flash'));
        $this->assertEquals('Bravo', $this->flashService->get('success'));
        $this->assertEquals('Bravo', $this->flashService->get('success'));
    }
}
