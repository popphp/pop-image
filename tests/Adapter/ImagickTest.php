<?php

namespace Pop\Image\Test\Adapter;

use Pop\Image;
use Pop\Image\Adapter\Imagick;

class ImagickTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Imagick')) {
            $this->markTestSkipped('Imagick is not installed');
        }
    }

    public function testLoadJpg()
    {
        $image = new Imagick();
        $image->load(__DIR__ . '/../tmp/test.jpg');
        $this->assertEquals('jpeg', $image->getFormat());
    }

    public function testLoadGif()
    {
        $image = new Imagick();
        $image->load(__DIR__ . '/../tmp/overlay.gif');
        $this->assertEquals('gif', $image->getFormat());
    }

    public function testLoadPng()
    {
        $image = new Imagick();
        $image->load(__DIR__ . '/../tmp/overlay.png');
        $this->assertEquals('png', $image->getFormat());
    }

    public function testLoadFromString()
    {
        $image = new Imagick();
        $image->loadFromString(file_get_contents(__DIR__ . '/../tmp/test.jpg'));
        $this->assertEquals('jpeg', $image->getFormat());
    }

    public function testLoadException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Imagick();
        $image->load('bad-image.jpg');
    }

    public function testLoadFromStringException()
    {
        $this->expectException('ImagickException');
        $image = new Imagick();
        $image->loadFromString('');
    }

    public function testCreate()
    {
        $image = new Imagick();
        $image->create(640, 480, 'test2.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreateIndex()
    {
        $image = new Imagick();
        $image->createIndex(640, 480, 'test.gif');
        $this->assertTrue($image->isIndexed());
    }

    public function testCreateJpg()
    {
        $image = new Imagick(640, 480, 'test2.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreatePng()
    {
        $image = new Imagick(640, 480, 'test.png');
        $image->writeToFile(__DIR__ . '/../tmp/test.png');
        $this->assertFileExists(__DIR__ . '/../tmp/test.png');
        unlink(__DIR__ . '/../tmp/test.png');
    }

    public function testCreateGif()
    {
        $image = new Imagick(640, 480, 'test.gif');
        $image->writeToFile(__DIR__ . '/../tmp/test.gif');
        $this->assertFileExists(__DIR__ . '/../tmp/test.gif');
        unlink(__DIR__ . '/../tmp/test.gif');
    }

    public function testSetAndGetImageFilter()
    {
        $image = new Imagick();
        $image->setImageFilter(\Imagick::FILTER_LANCZOS);
        $this->assertEquals(\Imagick::FILTER_LANCZOS, $image->getImageFilter());
    }

    public function testSetAndGetImageBlur()
    {
        $image = new Imagick();
        $image->setImageBlur(1.5);
        $this->assertEquals(1.5, $image->getImageBlur());
    }

    public function testSetAndGetImageCompression()
    {
        $image = new Imagick();
        $image->setCompression(50);
        $this->assertEquals(50, $image->getCompression());
    }

    public function testAdjust()
    {
        $image = new Imagick();
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testAdjustImageNotSet()
    {
        $image = new Imagick();
        $image->setAdjust(new Image\Adjust\Imagick());
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testDraw()
    {
        $image = new Imagick();
        $this->assertInstanceOf('Pop\Image\Draw\Imagick', $image->draw());
    }

    public function testDrawImageNotSet()
    {
        $image = new Imagick();
        $image->setDraw(new Image\Draw\Imagick());
        $this->assertInstanceOf('Pop\Image\Draw\Imagick', $image->draw());
    }

    public function testEffect()
    {
        $image = new Imagick();
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testEffectImageNotSet()
    {
        $image = new Imagick();
        $image->setEffect(new Image\Effect\Imagick());
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testFilter()
    {
        $image = new Imagick();
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testFilterImageNotSet()
    {
        $image = new Imagick();
        $image->setFilter(new Image\Filter\Imagick());
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testLayer()
    {
        $image = new Imagick();
        $this->assertInstanceOf('Pop\Image\Layer\Imagick', $image->layer());
    }

    public function testLayerImageNotSet()
    {
        $image = new Imagick();
        $image->setLayer(new Image\Layer\Imagick());
        $this->assertInstanceOf('Pop\Image\Layer\Imagick', $image->layer());
    }

    public function testType()
    {
        $image = new Imagick();
        $this->assertInstanceOf('Pop\Image\Type\Imagick', $image->type());
    }

    public function testTypeImageNotSet()
    {
        $image = new Imagick();
        $image->setType(new Image\Type\Imagick());
        $this->assertInstanceOf('Pop\Image\Type\Imagick', $image->type());
    }

    public function testResizeToWidth()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->resizeToWidth(320);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResizeToHeight()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->resizeToHeight(240);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResize()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
    }

    public function testScale()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->scale(0.5);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testCrop()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropIndexed()
    {
        $image = new Imagick(__DIR__ . '/../tmp/overlay.gif');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumb()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbIndexed()
    {
        $image = new Imagick(__DIR__ . '/../tmp/overlay.gif');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffset()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbVertical()
    {
        $image = new Imagick(480, 640, 'test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffsetVertical()
    {
        $image = new Imagick(480, 640, 'test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testRotate()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->rotate(45);
        $this->assertGreaterThan(770, $image->getWidth());
        $this->assertGreaterThan(770, $image->getHeight());
    }

    public function testFlip()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->flip();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testFlop()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->flop();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testConvert()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
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
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->writeToFile(__DIR__ . '/../tmp/test2.jpg', 150);
    }

    public function testWriteToFile()
    {
        copy(__DIR__ . '/../tmp/test.jpg', __DIR__ . '/../tmp/test2.jpg');
        $image = new Imagick(__DIR__ . '/../tmp/test2.jpg');
        $image->resize(240);
        $image->writeToFile();
        $this->assertFileExists(__DIR__ . '/../tmp/test2.jpg');
        unlink(__DIR__ . '/../tmp/test2.jpg');
        $this->assertFileNotExists(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testCreateColor1()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $color = $image->createColor(new \Pop\Image\Color\Cmyk(100, 80, 60, 40));
        $this->assertInstanceOf('ImagickPixel', $color);
    }

    public function testCreateColor2()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $color = $image->createColor(new \Pop\Image\Color\Gray(100));
        $this->assertInstanceOf('ImagickPixel', $color);
    }

    /**
     * @runInSeparateProcess
     */
    public function testOutputToHttpNotCreatedException()
    {
        $this->expectException('Pop\Image\Adapter\Exception');
        $image = new Imagick();
        $image->outputToHttp(__DIR__ . '/../tmp/test-240.jpg');
    }

    /**
     * @runInSeparateProcess
     */
    public function testOutputToHttpOutOfRangeException()
    {
        $this->expectException('OutOfRangeException');
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        $image->outputToHttp(150);
    }

    /**
     * @runInSeparateProcess
     */
    public function testOutputToHttp()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
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

    /**
     * @runInSeparateProcess
     */
    public function testToString()
    {
        $image = new Imagick(__DIR__ . '/../tmp/test.jpg');
        ob_start();
        echo $image;
        $result = ob_get_clean();
        $this->assertFalse(ctype_print($result));
    }
    
}