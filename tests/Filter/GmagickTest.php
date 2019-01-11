<?php

namespace Pop\Image\Test\Filter;

use Pop\Image\Adapter;
use PHPUnit\Framework\TestCase;

class GmagickTest extends TestCase
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
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->motionBlur(1);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testNegate()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->negate();
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testPaint()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->paint(2);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testNoise()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->noise();
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testDiffuse()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->diffuse(5);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testSkew()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->skew(4, 4);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testSolarize()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->solarize(1);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testSwirl()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->swirl(5);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testPixelate()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->filter()->pixelate(5);
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

}
