<?php

namespace Pop\Image\Test\Effect;

use Pop\Image;

class SvgTest extends \PHPUnit_Framework_TestCase
{

    public function testBorder()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->effect()->border([255, 0, 0], 10, 5, 10, 10);
        $this->assertInstanceOf('Pop\Image\Effect\Svg', $image->effect());
    }

    public function testBorderException()
    {
        $this->expectException('Pop\Image\Effect\Exception');
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->effect()->border([255, 0], 5);
    }

    public function testFill()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->effect()->fill(255, 0, 0);
        $this->assertInstanceOf('Pop\Image\Effect\Svg', $image->effect());
    }

    public function testRadialGradient()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->effect()->radialGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Svg', $image->effect());
    }

    public function testRadialGradientBadColorException()
    {
        $this->expectException('Pop\Image\Effect\Exception');
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->effect()->radialGradient([255, 0], [0, 0, 255]);
    }

    public function testVerticalGradient()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->effect()->verticalGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Svg', $image->effect());
    }

    public function testHorizontalGradient()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->effect()->horizontalGradient([255, 0, 0], [0, 0, 255]);
        $this->assertInstanceOf('Pop\Image\Effect\Svg', $image->effect());
    }

    public function testLinearGradientBadColorException()
    {
        $this->expectException('Pop\Image\Effect\Exception');
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->effect()->linearGradient([255, 0], [0, 0, 255]);
    }

}
