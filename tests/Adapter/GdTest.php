<?php

namespace Pop\Image\Test\Adapter;

use Pop\Image;
use Pop\Image\Adapter\Gd;
use PHPUnit\Framework\TestCase;

class GdTest extends TestCase
{

    public function testLoadJpg()
    {
        $image = new Gd();
        $image->load(__DIR__ . '/../tmp/test.jpg');
        $this->assertEquals('jpg', $image->getFormat());
        $this->assertTrue($image->hasResource());
        $this->assertEquals(__DIR__ . '/../tmp/test.jpg', $image->getName());
        $this->assertEquals(100, $image->getQuality());
        $this->assertEquals(2, $image->getColorspace());
        $this->assertTrue(is_array($image->getExif()));
        $this->assertFalse($image->isGray());
        $this->assertTrue($image->isRgb());
        $this->assertFalse($image->isCmyk());
    }

    public function testLoadGif()
    {
        $image = new Gd();
        $image->load(__DIR__ . '/../tmp/overlay.gif');
        $this->assertEquals('gif', $image->getFormat());
    }

    public function testLoadPng()
    {
        $image = new Gd();
        $image->load(__DIR__ . '/../tmp/overlay.png');
        $this->assertEquals('png', $image->getFormat());
    }

    public function testLoadException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Gd();
        $image->load('bad-image.jpg');
    }

    public function testLoadFromStringException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Gd();
        $image->loadFromString('');
    }

    public function testCreate()
    {
        $image = new Gd();
        $image->create(640, 480, 'test2.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreateJpg()
    {
        $image = new Gd(640, 480, 'test2.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreatePng()
    {
        $image = new Gd(640, 480, 'test.png');
        $image->writeToFile(__DIR__ . '/../tmp/test.png');
        $this->assertFileExists(__DIR__ . '/../tmp/test.png');
        unlink(__DIR__ . '/../tmp/test.png');
    }

    public function testCreateGif()
    {
        $image = new Gd(640, 480, 'test.gif');
        $image->writeToFile(__DIR__ . '/../tmp/test.gif');
        $this->assertFileExists(__DIR__ . '/../tmp/test.gif');
        unlink(__DIR__ . '/../tmp/test.gif');
    }

    public function testAdjust()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

    public function testAdjustImageNotSet()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

    public function testDraw()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Draw\Gd', $image->draw());
    }

    public function testDrawImageNotSet()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Draw\Gd', $image->draw());
    }

    public function testEffect()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testEffectImageNotSet()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testFilter()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testFilterImageNotSet()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testLayer()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testLayerImageNotSet()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testType()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testTypeImageNotSet()
    {
        $image = new Gd();
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testResizeToWidth()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->resizeToWidth(320);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResizeToHeight()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->resizeToHeight(240);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResize()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
    }

    public function testScale()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->scale(0.5);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testCrop()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropIndexed()
    {
        $image = new Gd(__DIR__ . '/../tmp/overlay.gif');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumb()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbIndexed()
    {
        $image = new Gd(__DIR__ . '/../tmp/overlay.gif');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffset()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbVertical()
    {
        $image = new Gd(480, 640, 'test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffsetVertical()
    {
        $image = new Gd(480, 640, 'test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testRotate()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->rotate(45);
        $this->assertGreaterThan(770, $image->getWidth());
        $this->assertGreaterThan(770, $image->getHeight());
    }

    public function testFlip()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->flip();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testFlop()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->flop();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testConvert()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->convert('gif');
        $this->assertEquals('gif', $image->getFormat());
        $image->convert('png');
        $this->assertEquals('png', $image->getFormat());
        $image->convert('jpg');
        $this->assertEquals('jpg', $image->getFormat());
    }

    public function testConvertTypeNotAllowedException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Gd(__DIR__ . '/tmp/test.jpg');
        $image->convert('psd');
    }

    public function testConvertNotCreatedException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Gd();
        $image->convert('jpg');
    }

    public function testWriteToFileNotCreatedException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Gd();
        $image->writeToFile(__DIR__ . '/../tmp/test-240.jpg');
    }

    public function testWriteToFileOutOfRangeException()
    {
        $this->expectException('OutOfRangeException');
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg', 150);
    }

    public function testWriteToFile()
    {
        copy(__DIR__ . '/../tmp/test.jpg', __DIR__ . '/../tmp/test2.jpg');
        $image = new Gd(__DIR__ . '/../tmp/test2.jpg');
        $image->resize(240);
        $image->writeToFile();
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileDoesNotExist(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreateColor()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $color = $image->createColor(new \Pop\Color\Color\Cmyk(100, 80, 60, 40));
        $this->assertTrue(is_numeric($color));
    }

    public function testCreateColorOutOfRangeException()
    {
        $this->expectException('OutOfRangeException');
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $color = $image->createColor(new \Pop\Color\Color\Rgb(100, 80, 60), 200);
    }

    public function testOutputToHttpNotCreatedException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Gd();
        $image->outputToHttp(null, __DIR__ . '/../tmp/test-240.jpg');
    }

    public function testOutputToHttpOutOfRangeException()
    {
        $this->expectException('OutOfRangeException');
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->outputToHttp(150);
    }

    public function testOutputToHttp()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
        $image->writeToFile(__DIR__ . '/../tmp/test-240.jpg');

        ob_start();
        $image->outputToHttp(100);
        $result = ob_get_clean();

        $image->destroy(true);
        $this->assertStringContainsString('JPEG', $result);
        $this->assertFileDoesNotExist(__DIR__ . '/../tmp/test-240.jpg');
    }

    public function testToString()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        ob_start();
        echo $image;
        $result = ob_get_clean();
        $this->assertStringContainsString('JPEG', $result);
    }

    public function testGetter()
    {
        $image = new Gd(__DIR__ . '/../tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Adjust\AbstractAdjust', $image->adjust);
        $this->assertInstanceOf('Pop\Image\Filter\AbstractFilter', $image->filter);
        $this->assertInstanceOf('Pop\Image\Layer\AbstractLayer', $image->layer);
        $this->assertInstanceOf('Pop\Image\Draw\AbstractDraw', $image->draw);
        $this->assertInstanceOf('Pop\Image\Effect\AbstractEffect', $image->effect);
        $this->assertInstanceOf('Pop\Image\Type\AbstractType', $image->type);
    }

}
