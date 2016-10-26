<?php

namespace Pop\Image\Test\Effect;

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

    public function testBorder()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->effect()->border([255, 0, 0], 10, 5);
        $this->assertInstanceOf('Pop\Image\Effect\Gmagick', $image->effect());
    }

    public function testBorderException()
    {
        $this->expectException('Pop\Image\Effect\Exception');
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->effect()->border([255, 0], 5);
    }

    public function testFill()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->effect()->fill(255, 0, 0);
        $this->assertInstanceOf('Pop\Image\Effect\Gmagick', $image->effect());
    }

}
