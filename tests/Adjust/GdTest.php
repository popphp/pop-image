<?php

namespace Pop\Image\Test\Adjust;

use Pop\Image\Adapter;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testBrightness()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->adjust()->brightness(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

    public function testContrast()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->adjust()->contrast(50);
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

    public function testDesaturate()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->adjust()->desaturate();
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

}
