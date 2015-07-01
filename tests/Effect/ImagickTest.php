<?php

namespace Pop\Image\Test\Effect;

use Pop\Image;

class ImagickTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Imagick')) {
            $this->markTestSkipped('Imagick is not installed');
        }
    }

    public function testBorder()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->effect()->border([255, 0, 0], 10, 5);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testBorderException()
    {
        $this->setExpectedException('Pop\Image\Effect\Exception');
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->effect()->border([255, 0], 5);
    }

    public function testFill()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->effect()->fill(255, 0, 0);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testRadialGradient()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->effect()->radialGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testHorizontalGradient()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->effect()->horizontalGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testVerticalGradient()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->effect()->verticalGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testLinearGradient()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->effect()->linearGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testLinearGradientHorizontal()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->effect()->linearGradient([255, 0, 0], [0, 0, 255], false);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

}
