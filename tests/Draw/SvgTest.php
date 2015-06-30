<?php

namespace Pop\Image\Test\Draw;

use Pop\Image;

class SvgTest extends \PHPUnit_Framework_TestCase
{

    public function testSetOpacity()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setOpacity(50);
        $this->assertEquals(50, $image->draw()->getOpacity());
    }

    public function testAddClippingPath()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->addClippingPath(1);
        $image->draw()->setCurrentClippingPath(1);
        $this->assertEquals(1, count($image->draw()->getClippingPaths()));
        $this->assertEquals(1, $image->draw()->getNumberOfClippingPaths());
        $image->draw()->clipping();
        $this->assertEquals(1, $image->draw()->getCurrentClippingPath());
        $image->draw()->clearClipping();
        $this->assertNull($image->draw()->getCurrentClippingPath());
    }

    public function testLine()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->line(50, 50, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testRectangle()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5, 10, 10);
        $image->draw()->rectangle(50, 50, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testRectangleWithClipping()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->addLinearGradient([255, 0, 0], [0, 0, 255]);
        $image->draw()->setOpacity(50);
        $image->draw()->addClippingPath(1);
        $image->draw()->setCurrentClippingPath(1);
        $image->draw()->clipping();
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->rectangle(50, 50, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testRoundedRectangle()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->roundedRectangle(50, 50, 150, 150, 10, 10);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testRoundedRectangleWithClipping()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->addClippingPath(1);
        $image->draw()->setCurrentClippingPath(1);
        $image->draw()->clipping();
        $image->draw()->roundedRectangle(50, 50, 150, 150, 10, 10);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testRoundedSquare()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->roundedSquare(50, 50, 150, 10);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testSquare()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->square(50, 50, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testEllipse()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->ellipse(50, 50, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testEllipseWithClipping()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->addClippingPath(1);
        $image->draw()->setCurrentClippingPath(1);
        $image->draw()->clipping();
        $image->draw()->ellipse(50, 50, 150, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testCircle()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->circle(50, 50, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testCircleWithClipping()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->addClippingPath(1);
        $image->draw()->setCurrentClippingPath(1);
        $image->draw()->clipping();
        $image->draw()->circle(50, 50, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testArc()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->arc(50, 50, 30, 80, 150);
        $image->draw()->arc(50, 50, 20, 135, 150);
        $image->draw()->arc(50, 50, 135, 220, 150);
        $image->draw()->arc(50, 50, 135, 300, 150);
        $image->draw()->arc(50, 50, 220, 320, 150);
        $image->draw()->arc(50, 50, 20, 220, 150);
        $image->draw()->arc(50, 50, 20, 330, 150);
        $image->draw()->arc(50, 50, 135, 20, 150);
        $image->draw()->arc(50, 50, 135, 145, 150);
        $image->draw()->arc(50, 50, 220, 20, 150);
        $image->draw()->arc(50, 50, 220, 135, 150);
        $image->draw()->arc(50, 50, 220, 235, 150);
        $image->draw()->arc(50, 50, 330, 20, 150);
        $image->draw()->arc(50, 50, 330, 135, 150);
        $image->draw()->arc(50, 50, 330, 220, 150);
        $image->draw()->arc(50, 50, 330, 345, 150);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testPolygon()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->polygon([
            ['x' => 50, 'y' => 50],
            ['x' => 150, 'y' => 150],
            ['x' => 250, 'y' => 250],
            ['x' => 350, 'y' => 350],
            ['x' => 450, 'y' => 450]
        ]);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testPolygonWithClipping()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->draw()->setFillColor(255, 128, 1);
        $image->draw()->setStrokeColor(0, 0, 0);
        $image->draw()->setStrokeWidth(5);
        $image->draw()->addClippingPath(1);
        $image->draw()->setCurrentClippingPath(1);
        $image->draw()->clipping();
        $image->draw()->polygon([
            ['x' => 50, 'y' => 50],
            ['x' => 150, 'y' => 150],
            ['x' => 250, 'y' => 250],
            ['x' => 350, 'y' => 350],
            ['x' => 450, 'y' => 450]
        ]);
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

}
