<?php

namespace Pop\Image\Test\Type;

use Pop\Image\Adapter;
use Pop\Color\Color\Rgb;
use PHPUnit\Framework\TestCase;

class ImagickTest extends TestCase
{

    public function testOpacity()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->type()->setOpacity(0.5);
        $this->assertEquals(0.5, $image->type()->getOpacity());
    }

    public function testText()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Imagick', $image->type());
    }

    public function testTextWithFont()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->type()->size(12);
        $image->type()->font(__DIR__ . '/../tmp/times.ttf');
        $image->type()->setStrokeColor(new Rgb(255, 128, 1));
        $image->type()->setStrokeWidth(1);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Imagick', $image->type());
    }

}
