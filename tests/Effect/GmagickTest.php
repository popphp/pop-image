<?php

namespace Pop\Image\Test\Effect;

use Pop\Image\Adapter;
use Pop\Image\Color\Rgb;
use PHPUnit\Framework\TestCase;

class GmagickTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Gmagick is not installed');
        }
    }

    public function testBorder()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->effect()->border(new Rgb(255, 0, 0), 10, 5);
        $this->assertInstanceOf('Pop\Image\Effect\Gmagick', $image->effect());
    }

    public function testFill()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->effect()->fill(new Rgb(255, 0, 0));
        $this->assertInstanceOf('Pop\Image\Effect\Gmagick', $image->effect());
    }

}
