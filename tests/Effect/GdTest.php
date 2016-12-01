<?php

namespace Pop\Image\Test\Effect;

use Pop\Image\Adapter;
use Pop\Image\Color\Rgb;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testBorder()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->effect()->border(new Rgb(255, 0, 0), 10, 5);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testFill()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->effect()->fill(new Rgb(255, 0, 0));
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());

        $image = new Adapter\Gd(640, 480, 'test.gif');
        $image->effect()->fill(new Rgb(255, 0, 0));
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testRadialGradient()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->effect()->radialGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testRadialGradientPortrait()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->effect()->radialGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testRadialGradientSquare()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->effect()->radialGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testVerticalGradient()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->effect()->verticalGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testHorizontalGradient()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->effect()->horizontalGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

}
