<?php

namespace Pop\Image\Test\Layer;

use Pop\Image\Adapter;
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

    public function testOpacity()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->layer()->setOpacity(50);
        $this->assertEquals(50, $image->layer()->getOpacity());
    }

    public function testSetOverlay()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->layer()->setOverlay(\Gmagick::COMPOSITE_ADD);
        $this->assertEquals(\Gmagick::COMPOSITE_ADD, $image->layer()->getOverlay());
    }

    public function testOverlay()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->layer()->setOpacity(0.5);
        $image->layer()->overlay(__DIR__ . '/../tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Layer\Gmagick', $image->layer());
    }

}
