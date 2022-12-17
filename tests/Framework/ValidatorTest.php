<?php

namespace Tests\Framework;

use Framework\validator;
use phpDocumentor\Reflection\Types\This;
use PHPUnit\Framework\TestCase;

use function DI\string;

class validatorTest extends TestCase
{

    public function makeValidator(array $params)
    {
        return new Validator($params);
    }

    public function testRequiredIfFail()
    {
        $errors = $this->makeValidator(['name' => 'joe'])
            ->required('name', 'content')
            ->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals("Le champ content est requis", (string)$errors['content']);
    }

    public function testNotEmpty()
    {
        $errors = $this->makeValidator(['name' => 'joe', 'content' => ''])
            ->notEmpty('content')
            ->getErrors();
        $this->assertCount(1, $errors);
    }

    public function testRequiredIfSuccess()
    {
        $errors = $this->makeValidator(['name' => 'joe', 'content' => ''])
            ->required('name', 'content')
            ->getErrors();
        $this->assertCount(0, $errors);
    }

    public function testSlugSuccess()
    {
        $errors = $this->makeValidator([
            'slug' => 'aze-azeAze43',
            'slug1' => 'aze-aze_Aze43',
            'slug2' => 'aze-aze--aze43'
        ])
            ->slug('slug')
            ->slug('slug1')
            ->slug('slug2')
            ->slug('slug3')
            ->getErrors();
        $this->assertCount(3, $errors);
    }

    public function testLength()
    {
        $params = [
            'slug' => '123456789',
        ];

        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3)->getErrors());
        $this->assertCount(1, $this->makeValidator($params)->length('slug', 12)->getErrors());
        $errors = $this->makeValidator($params)->length('slug', 3, 4)->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals('Le champ slug doit contenir entre 3 et 4 caracteres', (string)$errors['slug']);
        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3, 20)->getErrors());
        $this->assertCount(0, $this->makeValidator($params)->length('slug', null, 20)->getErrors());
        $this->assertCount(1, $this->makeValidator($params)->length('slug', null, 8)->getErrors());
    }

    public function testSlugError()
    {
        $errors = $this->makeValidator(['slug' => 'aze-azeaze43'])
            ->slug('slug')
            ->getErrors();
        $this->assertCount(0, $errors);
    }

    public function testDateTime()
    {
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 11:12:13'])->dateTime('date')->getErrors());
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 00:00:00'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2012-21-12'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2013-02-29 11:12:13'])->dateTime('date')->getErrors());
    }
}
