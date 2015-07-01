<?php

namespace Pop\Image\Test\Layer;

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

    public function testOpacity()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->layer()->setOpacity(50);
        $this->assertEquals(50, $image->layer()->getOpacity());
    }

    public function testSetOverlay()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->layer()->setOverlay(\Gmagick::COMPOSITE_ADD);
        $this->assertEquals(\Gmagick::COMPOSITE_ADD, $image->layer()->getOverlay());
    }

    public function testOverlay()
    {
        $image = new Image\Gmagick('test.jpg', 640, 480);
        $image->layer()->setOpacity(0.5);
        $image->layer()->overlay(__DIR__ . '/../tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Layer\Gmagick', $image->layer());
    }

}
