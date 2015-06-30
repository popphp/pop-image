<?php

namespace Pop\Image\Test\Layer;

use Pop\Image;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testOpacity()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->layer()->setOpacity(50);
        $this->assertEquals(50, $image->layer()->getOpacity());
    }

    public function testOverlayJpg()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->layer()->setOpacity(50);
        $image->layer()->overlay(__DIR__ . '/../tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testOverlayGif()
    {
        $image = new Image\Gd('test.gif', 640, 480);
        $image->layer()->overlay(__DIR__ . '/../tmp/overlay.gif');
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testOverlayPng()
    {
        $image = new Image\Gd('test.png', 640, 480);
        $image->layer()->overlay(__DIR__ . '/../tmp/overlay.png');
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testOverlayException()
    {
        $this->setExpectedException('Pop\Image\Layer\Exception');
        $image = new Image\Gd('test.png', 640, 480);
        $image->layer()->overlay('test.bad');
    }

}
