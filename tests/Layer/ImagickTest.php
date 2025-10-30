<?php

namespace Pop\Image\Test\Layer;

use Pop\Image\Adapter;
use PHPUnit\Framework\TestCase;

class ImagickTest extends TestCase
{

    public function testOpacity()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->layer()->setOpacity(50);
        $this->assertEquals(50, $image->layer()->getOpacity());
    }

    public function testSetOverlay()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->layer()->setOverlay(\Imagick::COMPOSITE_DEFAULT);
        $this->assertEquals(\Imagick::COMPOSITE_DEFAULT, $image->layer()->getOverlay());
    }

    public function testOverlay()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->layer()->setOpacity(0.5);
        $image->layer()->overlay(__DIR__ . '/../tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Layer\Imagick', $image->layer());
    }

    public function testFlatten()
    {
        $image = new Adapter\Imagick(640, 480, 'test.jpg');
        $image->layer()->setOpacity(0.5);
        $image->layer()->overlay(__DIR__ . '/../tmp/test.jpg');
        $image->layer()->flatten();
        $this->assertInstanceOf('Pop\Image\Layer\Imagick', $image->layer());
    }

}
