<?php

namespace Pop\Image\Test\Filter;

use Pop\Image\Adapter;
use Pop\Color\Color;
use PHPUnit\Framework\TestCase;

class ImagickTest extends TestCase
{

    public function testBlur()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->blur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testAdaptiveBlur()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->adaptiveBlur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testGaussianBlur()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->gaussianBlur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testMotionBlur()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->motionBlur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testSharpen()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->sharpen(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testNegate()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->negate();
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testPaint()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->paint(5);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testPosterize()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->posterize(5);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testNoise()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->noise();
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testDiffuse()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->diffuse(5);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testSkew1()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->skew(5, 10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testSkew2()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->skew(5, 10, new Color\Cmyk(100, 50, 50, 50));
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testSwirl()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->swirl(20);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testWave()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->wave(45, 20);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testPixelate()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->pixelate(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testPencil()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->filter()->pencil(10, 0, 10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

}
