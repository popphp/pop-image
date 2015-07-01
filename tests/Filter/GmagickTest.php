<?php

namespace Pop\Image\Test\Filter;

use Pop\Image;

class GmagickTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Gmagick is not installed');
        }
    }

    public function testMotionBlur()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->motionBlur(1);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testNegate()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->negate();
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testPaint()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->paint(2);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testNoise()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->noise();
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testDiffuse()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->diffuse(5);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testSkew()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->skew(4, 4);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testSolarize()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->solarize(1);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testSwirl()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->swirl(5);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testPixelate()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->filter()->pixelate(5);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

}
