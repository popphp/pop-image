<?php

namespace Pop\Image\Test\Adjust;

use Pop\Image;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testBrightness()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->adjust()->brightness(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

    public function testContrast()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->adjust()->contrast(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

    public function testDesaturate()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->adjust()->desaturate();
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

}
