<?php

namespace Pop\Image\Test\Filter;

use Pop\Image;

class ImagickTest extends \PHPUnit_Framework_TestCase
{

    public function testBlur()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->blur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testAdaptiveBlur()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->adaptiveBlur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testGaussianBlur()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->gaussianBlur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testMotionBlur()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->motionBlur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testRadialBlur()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->radialBlur(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testSharpen()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->sharpen(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testNegate()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->negate();
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testPaint()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->paint(5);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testPosterize()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->posterize(5);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testNoise()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->noise();
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testDiffuse()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->diffuse(5);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testSkew()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->skew(5, 10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testSwirl()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->swirl(20);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testWave()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->wave(45, 20);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testPixelate()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->pixelate(10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testPencil()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->filter()->pencil(10, 0, 10);
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

}
