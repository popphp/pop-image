<?php

namespace Pop\Image\Test\Type;

use Pop\Image\Adapter;
use Pop\Image\Color\Rgb;

class GmagickTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Gmagick is not installed');
        }
    }

    public function testOpacity()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->type()->setOpacity(0.5);
        $this->assertEquals(0.5, $image->type()->getOpacity());
    }

    public function testText()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Gmagick', $image->type());
    }

    public function testTextWithFont()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->type()->size(12);
        $image->type()->font(__DIR__ . '/../tmp/times.ttf');
        $image->type()->setStrokeColor(new Rgb(255, 128, 1));
        $image->type()->setStrokeWidth(1);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Gmagick', $image->type());
    }

}
