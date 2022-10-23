<?php

namespace Tests\Framework\Twig;

use Framework\Twig\TimeExtension;
use PHPUnit\Framework\TestCase;

class TimeExtensionTest extends TestCase
{


    /**
     * Undocumented variable
     *
     * @var TimeExtension
     */
    private $timeExtension;

    public function setUp(): void
    {
        $this->timeExtension = new TimeExtension();
    }


    public function testDateFormat()
    {
        $date = new \DateTime();
        $format = 'd/m/y H:i';

        $result = '<span class="timeago" datetime="' . $date->format(\DateTime::ISO8601) . '">' . $date->format($format) . '</span>';
        $this->assertEquals($result, $this->timeExtension->ago($date));
    }
}
