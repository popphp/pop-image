<?php

namespace Pop\Image\Test\Draw;

use Pop\Image\Adapter;
use Pop\Image\Color\Rgb;

class GmagickTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Gmagick is not installed');
        }
    }

    public function testSetOpacity()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setOpacity(50);
        $this->assertEquals(50, $image->draw()->getOpacity());
    }

    public function testLine()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->line(50, 50, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testRectangle()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->rectangle(50, 50, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testRoundedRectangle()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->roundedRectangle(50, 50, 150, 150, 10, 10);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testRoundedSquare()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->roundedSquare(50, 50, 150, 10);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testSquare()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->square(50, 50, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testEllipse()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->ellipse(50, 50, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testCircle()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->circle(50, 50, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testArc()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->arc(50, 50, 30, 80, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testChord()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->chord(50, 50, 30, 80, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testPie()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->pie(50, 50, 30, 80, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testPolygon()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.jpg');
        $image->draw()->setFillColor(new Rgb(255, 128, 1));
        $image->draw()->setStrokeColor(new Rgb(0, 0, 0));
        $image->draw()->setStrokeWidth(5);
        $image->draw()->polygon([
            ['x' => 50, 'y' => 50],
            ['x' => 150, 'y' => 150],
            ['x' => 250, 'y' => 250],
            ['x' => 350, 'y' => 350],
            ['x' => 450, 'y' => 450]
        ]);
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

}
