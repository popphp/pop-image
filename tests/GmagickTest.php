<?php

namespace Pop\Image\Test;

use Pop\Image;
use Pop\Image\Adapter;

class GmagickTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Gmagick is not installed');
        }
    }

    public function testCreatePng()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.png');
        $this->assertEquals('png', $image->getFormat());
        $image->writeToFile(__DIR__ . '/tmp/test.png');
        $this->assertFileExists(__DIR__ . '/tmp/test.png');
        unlink(__DIR__ . '/tmp/test.png');
    }

    public function testCreateGif()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.gif');
        $this->assertEquals('gif', $image->getFormat());
        $image->writeToFile(__DIR__ . '/tmp/test.gif');
        $this->assertFileExists(__DIR__ . '/tmp/test.gif');
        unlink(__DIR__ . '/tmp/test.gif');
    }

    public function testSetCompression()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.gif');
        $image->setCompression(50);
        $this->assertEquals(50, $image->getCompression());
    }

    public function testSetImageFilter()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.gif');
        $image->setImageFilter(\Gmagick::FILTER_CUBIC);
        $this->assertEquals(\Gmagick::FILTER_CUBIC, $image->getImageFilter());
    }

    public function testSetImageBlur()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.gif');
        $image->setImageBlur(5);
        $this->assertEquals(5, $image->getImageBlur());
    }

    public function testLoadException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Adapter\Gmagick();
        $image->load('bad.jpg');
    }

    public function testAdjust()
    {
        $image = new Adapter\Gmagick();
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testAdjustImageNotSet()
    {
        $image = new Adapter\Gmagick();
        $image->setAdjust(new Image\Adjust\Gmagick());
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testDraw()
    {
        $image = new Adapter\Gmagick();
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testDrawImageNotSet()
    {
        $image = new Adapter\Gmagick();
        $image->setDraw(new Image\Draw\Gmagick());
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testEffect()
    {
        $image = new Adapter\Gmagick();
        $this->assertInstanceOf('Pop\Image\Effect\Gmagick', $image->effect());
    }

    public function testEffectImageNotSet()
    {
        $image = new Adapter\Gmagick();
        $image->setEffect(new Image\Effect\Gmagick());
        $this->assertInstanceOf('Pop\Image\Effect\Gmagick', $image->effect());
    }

    public function testFilter()
    {
        $image = new Adapter\Gmagick();
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testFilterImageNotSet()
    {
        $image = new Adapter\Gmagick();
        $image->setFilter(new Image\Filter\Gmagick());
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testLayer()
    {
        $image = new Adapter\Gmagick();
        $this->assertInstanceOf('Pop\Image\Layer\Gmagick', $image->layer());
    }

    public function testLayerImageNotSet()
    {
        $image = new Adapter\Gmagick();
        $image->setLayer(new Image\Layer\Gmagick());
        $this->assertInstanceOf('Pop\Image\Layer\Gmagick', $image->layer());
    }

    public function testType()
    {
        $image = new Adapter\Gmagick();
        $this->assertInstanceOf('Pop\Image\Type\Gmagick', $image->type());
    }

    public function testTypeImageNotSet()
    {
        $image = new Adapter\Gmagick();
        $image->setType(new Image\Type\Gmagick());
        $this->assertInstanceOf('Pop\Image\Type\Gmagick', $image->type());
    }

    public function testResizeToWidth()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->resizeToWidth(320);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResizeToHeight()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->resizeToHeight(240);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResize()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
    }

    public function testScale()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->scale(0.5);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testCrop()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumb()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffset()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbVertical()
    {
        $image = new Adapter\Gmagick(480, 640, 'test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffsetVertical()
    {
        $image = new Adapter\Gmagick(480, 640, 'test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testRotate()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->rotate(45);
        $this->assertGreaterThan(770, $image->getWidth());
        $this->assertGreaterThan(770, $image->getHeight());
    }

    public function testFlip()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->flip();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testFlop()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->flop();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testConvert()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->convert('gif');
        $this->assertEquals('gif', $image->getFormat());
        $image->convert('png');
        $this->assertEquals('png', $image->getFormat());
        $image->convert('jpg');
        $this->assertEquals('jpg', $image->getFormat());
    }

    public function testConvertPsd()
    {
        $image = new Adapter\Gmagick(640, 480, 'test.psd');
        $this->assertEquals('psd', $image->getFormat());
        $image->convert('png');
        $this->assertEquals('png', $image->getFormat());
    }

    public function testWriteToFile()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');
        $image->setCompression(50);
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
        $image->writeToFile(__DIR__ . '/tmp/test-240.jpg');
        $this->assertFileExists(__DIR__ . '/tmp/test-240.jpg');
        unlink(__DIR__ . '/tmp/test-240.jpg');
    }

    /**
     * @runInSeparateProcess
     */
    public function testToString()
    {
        $image = new Adapter\Gmagick(__DIR__ . '/tmp/test.jpg');

        ob_start();
        echo $image;
        $result = ob_get_clean();

        $image->destroy();
        $this->assertFalse(ctype_print($result));
        $this->assertFileNotExists(__DIR__ . '/tmp/test-240.jpg');
    }

}
