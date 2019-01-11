<?php

namespace Pop\Image\Test\Layer;

use Pop\Image\Adapter;
use PHPUnit\Framework\TestCase;

class GdTest extends TestCase
{

    public function testOpacity()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->layer()->setOpacity(50);
        $this->assertEquals(50, $image->layer()->getOpacity());
    }

    public function testOverlayJpg()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->layer()->setOpacity(50);
        $image->layer()->overlay(__DIR__ . '/../tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testOverlayGif()
    {
        $image = new Adapter\Gd(640, 480, 'test.gif');
        $image->layer()->overlay(__DIR__ . '/../tmp/overlay.gif');
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testOverlayPng()
    {
        $image = new Adapter\Gd(640, 480, 'test.png');
        $image->layer()->overlay(__DIR__ . '/../tmp/overlay.png');
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testOverlayException()
    {
        $this->expectException('Pop\Image\Layer\Exception');
        $image = new Adapter\Gd(640, 480,'test.png');
        $image->layer()->overlay('test.bad');
    }

}
