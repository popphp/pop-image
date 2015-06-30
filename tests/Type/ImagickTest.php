<?php

namespace Pop\Image\Test\Type;

use Pop\Image;

class ImagickTest extends \PHPUnit_Framework_TestCase
{

    public function testOpacity()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->type()->setOpacity(0.5);
        $this->assertEquals(0.5, $image->type()->getOpacity());
    }

    public function testText()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Imagick', $image->type());
    }

    public function testTextWithFont()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->type()->size(12);
        $image->type()->font(__DIR__ . '/../tmp/times.ttf');
        $image->type()->setStrokeColor(255, 128, 1);
        $image->type()->setStrokeWidth(1);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Imagick', $image->type());
    }

}
