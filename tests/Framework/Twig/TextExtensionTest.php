<?php

namespace Tests\Framework\Twig;

use Framework\Twig\TextExtension;
use PHPUnit\Framework\TestCase;

class TextExtensionTest extends TestCase
{


    /**
     * Undocumented variable
     *
     * @var TextExtension
     */
    private TextExtension $textExtension;

    public function setUp(): void
    {
        $this->TextExtension = new TextExtension();
    }


    public function textExcerptWithShortText()
    {
        $text = "salut";

        $this->assertEquals($text, $this->textExtension->excerpt($text, 10));
    }

    public function textExcerptWithLongText()
    {
        $text = "salut les gens";

        $this->assertEquals('salut...', $this->textExtension->excerpt($text, 7));
        $this->assertEquals('salut...', $this->textExtension->excerpt($text, 12));
    }
}
