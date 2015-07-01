<?php

namespace Pop\Image\Test\Layer;

use Pop\Image;

class ImagickTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Imagick')) {
            $this->markTestSkipped('Imagick is not installed');
        }
    }

    public function testOpacity()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->layer()->setOpacity(50);
        $this->assertEquals(50, $image->layer()->getOpacity());
    }

    public function testSetOverlay()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->layer()->setOverlay(\Imagick::COMPOSITE_ADD);
        $this->assertEquals(\Imagick::COMPOSITE_ADD, $image->layer()->getOverlay());
    }

    public function testOverlay()
    {
        $image = new Image\Imagick('test.jpg', 640, 480);
        $image->layer()->setOpacity(0.5);
        $image->layer()->overlay(__DIR__ . '/../tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Layer\Imagick', $image->layer());
    }

}
