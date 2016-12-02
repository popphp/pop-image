<?php

namespace Pop\Image\Test\Color;

use Pop\Image\Color;

class CmykTest extends \PHPUnit_Framework_TestCase
{

    public function testCmyk()
    {
        $color = new Color\Cmyk(100, 80, 60, 40);
        $this->assertInstanceOf('Pop\Image\Color\Cmyk', $color);
        $this->assertEquals(100, $color->getC());
        $this->assertEquals(80, $color->getM());
        $this->assertEquals(60, $color->getY());
        $this->assertEquals(40, $color->getK());
        $this->assertEquals('100, 80, 60, 40', (string)$color);
    }

    public function testToRgb()
    {
        $color = new Color\Cmyk(100, 80, 60, 40);
        $rgb = $color->toRgb();
        $this->assertInstanceOf('Pop\Image\Color\Rgb', $rgb);
    }

    public function testToGray()
    {
        $color = new Color\Cmyk(100, 80, 60, 40);
        $gray = $color->toGray();
        $this->assertInstanceOf('Pop\Image\Color\Gray', $gray);
    }

    public function testSetCException()
    {
        $this->expectException('OutOfRangeException');
        $color = new Color\Cmyk(200, 80, 60, 40);
    }

    public function testSetMException()
    {
        $this->expectException('OutOfRangeException');
        $color = new Color\Cmyk(100, 280, 60, 40);
    }

    public function testSetYException()
    {
        $this->expectException('OutOfRangeException');
        $color = new Color\Cmyk(100, 80, 260, 40);
    }

    public function testSetKException()
    {
        $this->expectException('OutOfRangeException');
        $color = new Color\Cmyk(100, 80, 60, 240);
    }

}