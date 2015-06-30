<?php

namespace Pop\Image\Test\Effect;

use Pop\Image;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testBorder()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->effect()->border([255, 0, 0], 10, 5);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testBorderException()
    {
        $this->setExpectedException('Pop\Image\Effect\Exception');
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->effect()->border([255, 0], 5);
    }

    public function testFill()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->effect()->fill(255, 0, 0);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());

        $image = new Image\Gd('test.gif', 640, 480);
        $image->effect()->fill(255, 0, 0);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testRadialGradient()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->effect()->radialGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testRadialGradientPortrait()
    {
        $image = new Image\Gd('test.jpg', 480, 640);
        $image->effect()->radialGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testRadialGradientSquare()
    {
        $image = new Image\Gd('test.jpg', 480, 480);
        $image->effect()->radialGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testVerticalGradient()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->effect()->verticalGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testHorizontalGradient()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->effect()->horizontalGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

}
