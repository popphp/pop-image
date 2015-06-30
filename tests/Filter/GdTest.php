<?php

namespace Pop\Image\Test\Filter;

use Pop\Image;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testBlur()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->filter()->blur(50);
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testSharpen()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->filter()->sharpen(50);
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testNegate()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->filter()->negate();
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testColorize()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->filter()->colorize(255, 0, 0);
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testPixelate()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->filter()->pixelate(10);
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testPencil()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->filter()->pencil();
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

}
