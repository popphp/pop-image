<?php

namespace Pop\Image\Test\Adjust;

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

    public function testHue()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->adjust()->hue(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testSaturation()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->adjust()->saturation(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testBrightness()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->adjust()->brightness(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testHsb()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->adjust()->hsb(50, 50, 50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testLevel()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->adjust()->level(-5, 50, 260);
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testContrast()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->adjust()->contrast(50);
        $image->adjust()->contrast(-50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testDesaturate()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->adjust()->desaturate();
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

}
