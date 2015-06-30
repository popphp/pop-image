<?php

namespace Pop\Image\Test;

use Pop\Image;

class SvgTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $image = new Image\Svg('test.svg', 640, 480);
        $this->assertInstanceOf('Pop\Image\Svg', $image);
        $image = new Image\Svg(640, 480, 'test.svg');
        $this->assertInstanceOf('Pop\Image\Svg', $image);
        $image->save(__DIR__ . '/tmp/test.svg');
        $this->assertFileExists(__DIR__ . '/tmp/test.svg');
        $image = new Image\Svg(__DIR__ . '/tmp/test.svg');
        $this->assertInstanceOf('Pop\Image\Svg', $image);
        $image->destroy(true);
    }

    public function testSetImageException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Svg();
        $image->create(640, 480, 'test.bad');
    }

    public function testSetUnits()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $this->assertEquals('px', $image->getUnits());
    }

    public function testDraw()
    {
        $image = new Image\Svg();
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testDrawImageNotSet()
    {
        $image = new Image\Svg();
        $image->setDraw(new Image\Draw\Svg());
        $this->assertInstanceOf('Pop\Image\Draw\Svg', $image->draw());
    }

    public function testEffect()
    {
        $image = new Image\Svg();
        $this->assertInstanceOf('Pop\Image\Effect\Svg', $image->effect());
    }

    public function testEffectImageNotSet()
    {
        $image = new Image\Svg();
        $image->setEffect(new Image\Effect\Svg());
        $this->assertInstanceOf('Pop\Image\Effect\Svg', $image->effect());
    }

    public function testType()
    {
        $image = new Image\Svg();
        $this->assertInstanceOf('Pop\Image\Type\Svg', $image->type());
    }

    public function testTypeImageNotSet()
    {
        $image = new Image\Svg();
        $image->setType(new Image\Type\Svg());
        $this->assertInstanceOf('Pop\Image\Type\Svg', $image->type());
    }

    public function testAddRadialGradientWrongNumberOfColorsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->addRadialGradient([0, 0], [255, 255, 255], 0.75);
    }

    public function testAddRadialGradientColorOutOfRangeException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->addRadialGradient([0, 0, 300], [255, 255, 255], 0.75);
    }

    public function testAddLinearGradientWrongNumberOfColorsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->addLinearGradient([0, 0], [255, 255, 255], 0.75);
    }

    public function testAddLinearGradientColorOutOfRangeException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->addLinearGradient([0, 0, 300], [255, 255, 255], 0.75);
    }

    /**
     * @runInSeparateProcess
     */
    public function testAddRadialGradient()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->addRadialGradient([0, 0, 0], [255, 255, 255], 0.75);

        ob_start();
        $image->output();;
        $result = ob_get_clean();

        $this->assertContains('stop-color: rgb(', $result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testAddLinearGradient()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->addLinearGradient([0, 0, 0], [255, 255, 255], 0.75);

        ob_start();
        $image->output();;
        $result = ob_get_clean();

        $this->assertContains('stop-color: rgb(', $result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testAddLinearGradientHorizontal()
    {
        $image = new Image\Svg('test.svg', '640px', '480px');
        $image->addLinearGradient([0, 0, 0], [255, 255, 255], 0.75, false);

        ob_start();
        $image->output();;
        $result = ob_get_clean();

        $this->assertContains('stop-color: rgb(', $result);
        $this->assertTrue(is_array($image->getGradients()));
        $this->assertEquals(1, $image->getNumberOfGradients());
        $image->setCurGradient(0);
        $this->assertEquals(0, $image->getCurGradient());
    }

    /**
     * @runInSeparateProcess
     */
    public function testOutput()
    {
        $image = new Image\Svg('test.svg', 640, 480);

        ob_start();
        $image->output();
        $result = ob_get_clean();

        $this->assertContains('<?xml version=', $result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testToString()
    {
        $image = new Image\Svg('test.svg', 640, 480);

        ob_start();
        echo $image;
        $result = ob_get_clean();

        $this->assertContains('<?xml version=', $result);
    }

}
