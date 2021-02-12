<?php

namespace Pop\Image\Test\Adjust;

use Pop\Image\Adapter;
use PHPUnit\Framework\TestCase;

class ImagickTest extends TestCase
{

    public function testHue()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->adjust()->hue(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testSaturation()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->adjust()->saturation(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testBrightness()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->adjust()->brightness(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testHsb()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->adjust()->hsb(50, 50, 50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testLevel()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->adjust()->level(-5, 50, 260);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testContrast()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->adjust()->contrast(50);
        $image->adjust()->contrast(-50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testDesaturate()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->adjust()->desaturate();
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

}
