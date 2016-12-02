<?php

namespace Pop\Image\Test\Color;

use Pop\Image\Color;

class RgbTest extends \PHPUnit_Framework_TestCase
{

    public function testRgb()
    {
        $color = new Color\Rgb(100, 80, 60);
        $this->assertInstanceOf('Pop\Image\Color\Rgb', $color);
        $this->assertEquals(100, $color->getR());
        $this->assertEquals(80, $color->getG());
        $this->assertEquals(60, $color->getB());
    }

    public function testToCmyk1()
    {
        $color = new Color\Rgb(100, 80, 60);
        $cmyk = $color->toCmyk();
        $this->assertInstanceOf('Pop\Image\Color\Cmyk', $cmyk);
    }

    public function testToCmyk2()
    {
        $color = new Color\Rgb(80, 100, 60);
        $cmyk = $color->toCmyk();
        $this->assertInstanceOf('Pop\Image\Color\Cmyk', $cmyk);
    }

    public function testToCmyk3()
    {
        $color = new Color\Rgb(80, 60, 100);
        $cmyk = $color->toCmyk();
        $this->assertInstanceOf('Pop\Image\Color\Cmyk', $cmyk);
    }

    public function testToCmyk4()
    {
        $color = new Color\Rgb(0, 0, 0);
        $cmyk = $color->toCmyk();
        $this->assertInstanceOf('Pop\Image\Color\Cmyk', $cmyk);
    }

    public function testToGray()
    {
        $color = new Color\Rgb(100, 80, 60);
        $gray = $color->toGray();
        $this->assertInstanceOf('Pop\Image\Color\Gray', $gray);
    }

    public function testSetRException()
    {
        $this->expectException('OutOfRangeException');
        $color = new Color\Rgb(300, 80, 60);
    }

    public function testSetGException()
    {
        $this->expectException('OutOfRangeException');
        $color = new Color\Rgb(100, 280, 60);
    }

    public function testSetBException()
    {
        $this->expectException('OutOfRangeException');
        $color = new Color\Rgb(100, 80, 260);
    }

}