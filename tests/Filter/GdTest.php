<?php

namespace Pop\Image\Test\Filter;

use Pop\Image\Adapter;
use Pop\Image\Color\Rgb;
use PHPUnit\Framework\TestCase;

class GdTest extends TestCase
{

    public function testBlur()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->filter()->blur(50);
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testSharpen()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->filter()->sharpen(50);
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testNegate()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->filter()->negate();
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testColorize()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->filter()->colorize(new Rgb(255, 0, 0));
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testPixelate()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->filter()->pixelate(10);
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testPencil()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->filter()->pencil();
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

}
