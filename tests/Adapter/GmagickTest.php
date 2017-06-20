<?php

namespace Pop\Image\Test\Adapter;

use Pop\Image;
use Pop\Image\Adapter\Gmagick;

class GmagickTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Gmagick is not installed');
        }
    }

    public function testLoadJpg()
    {
        $image = new Gmagick();
        $image->load(__DIR__ . '/../tmp/test.jpg');
        $this->assertEquals('jpeg', $image->getFormat());
    }

    public function testLoadGif()
    {
        $image = new Gmagick();
        $image->load(__DIR__ . '/../tmp/overlay.gif');
        $this->assertEquals('gif', $image->getFormat());
    }

    public function testLoadPng()
    {
        $image = new Gmagick();
        $image->load(__DIR__ . '/../tmp/overlay.png');
        $this->assertEquals('png', $image->getFormat());
    }

    public function testLoadFromString()
    {
        $image = new Gmagick();
        $image->loadFromString(file_get_contents(__DIR__ . '/../tmp/test.jpg'));
        $this->assertEquals('jpeg', $image->getFormat());
    }

    public function testLoadException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Gmagick();
        $image->load('bad-image.jpg');
    }

    public function testLoadFromStringException()
    {
        $this->expectException('GmagickException');
        $image = new Gmagick();
        $image->loadFromString('');
    }

    public function testCreate()
    {
        $image = new Gmagick();
        $image->create(640, 480, 'test2.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreateIndex()
    {
        $image = new Gmagick();
        $image->createIndex(640, 480, 'test.gif');
        $this->assertTrue($image->isIndexed());
    }

    public function testCreateJpg()
    {
        $image = new Gmagick(640, 480, 'test2.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreatePng()
    {
        $image = new Gmagick(640, 480, 'test.png');
        $image->writeToFile(__DIR__ . '/../tmp/test.png');
        $this->assertFileExists(__DIR__ . '/../tmp/test.png');
        unlink(__DIR__ . '/../tmp/test.png');
    }

    public function testCreateGif()
    {
        $image = new Gmagick(640, 480, 'test.gif');
        $image->writeToFile(__DIR__ . '/../tmp/test.gif');
        $this->assertFileExists(__DIR__ . '/../tmp/test.gif');
        unlink(__DIR__ . '/../tmp/test.gif');
    }

    public function testSetAndGetImageFilter()
    {
        $image = new Gmagick();
        $image->setImageFilter(\Gmagick::FILTER_LANCZOS);
        $this->assertEquals(\Gmagick::FILTER_LANCZOS, $image->getImageFilter());
    }

    public function testSetAndGetImageBlur()
    {
        $image = new Gmagick();
        $image->setImageBlur(1.5);
        $this->assertEquals(1.5, $image->getImageBlur());
    }

    public function testSetAndGetImageCompression()
    {
        $image = new Gmagick();
        $image->setCompression(50);
        $this->assertEquals(50, $image->getCompression());
    }

    public function testAdjust()
    {
        $image = new Gmagick();
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testAdjustImageNotSet()
    {
        $image = new Gmagick();
        $image->setAdjust(new Image\Adjust\Gmagick());
        $this->assertInstanceOf('Pop\Image\Adjust\Gmagick', $image->adjust());
    }

    public function testDraw()
    {
        $image = new Gmagick();
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testDrawImageNotSet()
    {
        $image = new Gmagick();
        $image->setDraw(new Image\Draw\Gmagick());
        $this->assertInstanceOf('Pop\Image\Draw\Gmagick', $image->draw());
    }

    public function testEffect()
    {
        $image = new Gmagick();
        $this->assertInstanceOf('Pop\Image\Effect\Gmagick', $image->effect());
    }

    public function testEffectImageNotSet()
    {
        $image = new Gmagick();
        $image->setEffect(new Image\Effect\Gmagick());
        $this->assertInstanceOf('Pop\Image\Effect\Gmagick', $image->effect());
    }

    public function testFilter()
    {
        $image = new Gmagick();
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testFilterImageNotSet()
    {
        $image = new Gmagick();
        $image->setFilter(new Image\Filter\Gmagick());
        $this->assertInstanceOf('Pop\Image\Filter\Gmagick', $image->filter());
    }

    public function testLayer()
    {
        $image = new Gmagick();
        $this->assertInstanceOf('Pop\Image\Layer\Gmagick', $image->layer());
    }

    public function testLayerImageNotSet()
    {
        $image = new Gmagick();
        $image->setLayer(new Image\Layer\Gmagick());
        $this->assertInstanceOf('Pop\Image\Layer\Gmagick', $image->layer());
    }

    public function testType()
    {
        $image = new Gmagick();
        $this->assertInstanceOf('Pop\Image\Type\Gmagick', $image->type());
    }

    public function testTypeImageNotSet()
    {
        $image = new Gmagick();
        $image->setType(new Image\Type\Gmagick());
        $this->assertInstanceOf('Pop\Image\Type\Gmagick', $image->type());
    }

    public function testResizeToWidth()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->resizeToWidth(320);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResizeToHeight()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->resizeToHeight(240);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResize()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
    }

    public function testScale()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->scale(0.5);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testCrop()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropIndexed()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/overlay.gif');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumb()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbIndexed()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/overlay.gif');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffset()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbVertical()
    {
        $image = new Gmagick(480, 640, 'test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffsetVertical()
    {
        $image = new Gmagick(480, 640, 'test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testRotate()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->rotate(45);
        $this->assertGreaterThan(770, $image->getWidth());
        $this->assertGreaterThan(770, $image->getHeight());
    }

    public function testFlip()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->flip();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testFlop()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->flop();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testConvert()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->convert('gif');
        $this->assertEquals('gif', $image->getFormat());
        $image->convert('png');
        $this->assertEquals('png', $image->getFormat());
        $image->convert('jpg');
        $this->assertEquals('jpg', $image->getFormat());
    }

    public function testWriteToFileOutOfRangeException()
    {
        $this->expectException('OutOfRangeException');
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg', 150);
    }

    public function testWriteToFile()
    {
        copy(__DIR__ . '/../tmp/test.jpg', __DIR__ . '/../tmp/test2.jpg');
        $image = new Gmagick(__DIR__ . '/../tmp/test2.jpg');
        $image->resize(240);
        $image->writeToFile();
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileNotExists(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreateColor1()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $color = $image->createColor(new \Pop\Image\Color\Cmyk(100, 80, 60, 40));
        $this->assertInstanceOf('GmagickPixel', $color);
    }

    public function testCreateColor2()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $color = $image->createColor(new \Pop\Image\Color\Gray(100));
        $this->assertInstanceOf('GmagickPixel', $color);
    }

    public function testOutputToHttpNotCreatedException()
    {
        $this->expectException('GmagickException');
        $image = new Gmagick();
        $image->outputToHttp(__DIR__ . '/../tmp/test-240.jpg');
    }

    public function testOutputToHttpOutOfRangeException()
    {
        $this->expectException('OutOfRangeException');
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->outputToHttp(150);
    }

    public function testOutputToHttp()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
        $image->setCompression(50);
        $image->writeToFile(__DIR__ . '/../tmp/test-240.jpg');

        ob_start();
        $image->outputToHttp(100);
        $result = ob_get_clean();

        $image->destroy(true);
        $this->assertFalse(ctype_print($result));
        $this->assertFileNotExists(__DIR__ . '/../tmp/test-240.jpg');
    }

    public function testToString()
    {
        $image = new Gmagick(__DIR__ . '/../tmp/test.jpg');
        ob_start();
        echo $image;
        $result = ob_get_clean();
        $this->assertFalse(ctype_print($result));
    }

}