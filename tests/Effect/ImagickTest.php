<?php

namespace Pop\Image\Test\Effect;

use Pop\Image\Adapter;
use Pop\Image\Color\Rgb;
use Pop\Image\Color\Cmyk;
use Pop\Image\Color\Gray;
use PHPUnit\Framework\TestCase;

class ImagickTest extends TestCase
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
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->border(new Rgb(255, 0, 0), 10, 5);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testFill()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->fill(new Rgb(255, 0, 0));
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testRadialGradient()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->radialGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testHorizontalGradient()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->horizontalGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testVerticalGradient()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->verticalGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testLinearGradient()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->linearGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testLinearGradientHorizontal()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->linearGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255), false);
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testRadialGradient2()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->radialGradient(new Gray(100), new Gray(0));
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testHorizontalGradient2()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->horizontalGradient(new Cmyk(100, 0, 0, 0), new Cmyk(0, 0, 0, 100));
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testVerticalGradient2()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->effect()->verticalGradient(new Gray(100), new Gray(0));
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }
}
