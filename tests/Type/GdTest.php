<?php

namespace Pop\Image\Test\Type;

use Pop\Image\Adapter;
use Pop\Color\Color\Rgb;
use PHPUnit\Framework\TestCase;

class GdTest extends TestCase
{

    public function testOpacity()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->setOpacity(50);
        $this->assertEquals(64, $image->type()->getOpacity());
    }

    public function testSetFillColor()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->setFillColor(new Rgb(255, 128, 1));
        $this->assertEquals(255, $image->type()->getFillColor()->getR());
        $this->assertEquals(128, $image->type()->getFillColor()->getG());
        $this->assertEquals(1, $image->type()->getFillColor()->getB());
    }

    public function testSetStrokeColor()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->setStrokeColor(new Rgb(255, 128, 1));
        $this->assertEquals(255, $image->type()->getStrokeColor()->getR());
        $this->assertEquals(128, $image->type()->getStrokeColor()->getG());
        $this->assertEquals(1, $image->type()->getStrokeColor()->getB());
    }

    public function testSetStrokeWidth()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->setStrokeWidth(5);
        $this->assertEquals(5, $image->type()->getStrokeWidth());
    }

    public function testSize()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->size(12);
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testXandY()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->x(50);
        $image->type()->y(50);
        $image->type()->xy(50, 50);
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testRotate()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->rotate(45);
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testText()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->size(12);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());

        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->size(0);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testTextWithFont()
    {
        $image = new Adapter\Gd(640, 480, 'test.jpg');
        $image->type()->size(12);
        $image->type()->font(__DIR__ . '/../tmp/times.ttf');
        $image->type()->setStrokeColor(new Rgb(255, 128, 1));
        $image->type()->setStrokeWidth(1);
        $image->type()->text('Hello World');
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

}
