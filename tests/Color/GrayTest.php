<?php

namespace Pop\Image\Test\Color;

use Pop\Image\Color;
use PHPUnit\Framework\TestCase;

class GrayTest extends TestCase
{

    public function testGray()
    {
        $color = new Color\Gray(50);
        $this->assertInstanceOf('Pop\Image\Color\Gray', $color);
        $this->assertEquals(50, $color->getGray());
        $this->assertEquals('50', (string)$color);
    }

    public function testToRgb()
    {
        $color = new Color\Gray(50);
        $rgb = $color->toRgb();
        $this->assertInstanceOf('Pop\Image\Color\Rgb', $rgb);
    }

    public function testToCmyk()
    {
        $color = new Color\Gray(50);
        $cmyk = $color->toCmyk();
        $this->assertInstanceOf('Pop\Image\Color\Cmyk', $cmyk);
    }

    public function testSetGrayException()
    {
        $this->expectException('OutOfRangeException');
        $color = new Color\Gray(200);
    }

}