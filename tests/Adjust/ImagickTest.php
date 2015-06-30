<?php

namespace Pop\Image\Test\Adjust;

use Pop\Image;

class ImagickTest extends \PHPUnit_Framework_TestCase
{

    public function testHue()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->adjust()->hue(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testSaturation()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->adjust()->saturation(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testBrightness()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->adjust()->brightness(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testHsb()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->adjust()->hsb(50, 50, 50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testLevel()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->adjust()->level(-5, 50, 260);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testContrast()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->adjust()->contrast(50);
        $image->adjust()->contrast(-50);
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testDesaturate()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->adjust()->desaturate();
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

}
