<?php

namespace Pop\Image\Test\Type;

use Pop\Image;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testOpacity()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->setOpacity(50);
        $this->assertEquals(64, $image->type()->getOpacity());
    }

    public function testSetFillColor()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->setFillColor(255, 128, 1);
        $this->assertEquals(255, $image->type()->getFillColor()[0]);
        $this->assertEquals(128, $image->type()->getFillColor()[1]);
        $this->assertEquals(1, $image->type()->getFillColor()[2]);
    }

    public function testSetStrokeColor()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->setStrokeColor(255, 128, 1);
        $this->assertEquals(255, $image->type()->getStrokeColor()[0]);
        $this->assertEquals(128, $image->type()->getStrokeColor()[1]);
        $this->assertEquals(1, $image->type()->getStrokeColor()[2]);
    }

    public function testSetStrokeWidth()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->setStrokeWidth(5);
        $this->assertEquals(5, $image->type()->getStrokeWidth());
    }

    public function testSize()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->size(12);
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testXandY()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->x(50);
        $image->type()->y(50);
        $image->type()->xy(50, 50);
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testRotate()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->rotate(45);
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testText()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->size(12);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());

        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->size(0);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testTextWithFont()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->type()->size(12);
        $image->type()->font(__DIR__ . '/../tmp/times.ttf');
        $image->type()->setStrokeColor(255, 128, 1);
        $image->type()->setStrokeWidth(1);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

}
