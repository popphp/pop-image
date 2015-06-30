<?php

namespace Pop\Image\Test;

use Pop\Image;

class ImagickTest extends \PHPUnit_Framework_TestCase
{

    public function testCreatePng()
    {
        $image = new Image\Imagick('test.png', 640, 480);
        $this->assertEquals('image/png', $image->getMime());
        $image->save(__DIR__ . '/tmp/test.png');
        $this->assertFileExists(__DIR__ . '/tmp/test.png');
        unlink(__DIR__ . '/tmp/test.png');
    }

    public function testCreateGif()
    {
        $image = new Image\Imagick('test.gif', 640, 480);
        $this->assertEquals('image/gif', $image->getMime());
        $image->save(__DIR__ . '/tmp/test.gif');
        $this->assertFileExists(__DIR__ . '/tmp/test.gif');
        unlink(__DIR__ . '/tmp/test.gif');
    }

    public function testGetFormats()
    {
        $this->assertGreaterThan(5, count(Image\Imagick::getFormats()));
    }

    public function testSetCompression()
    {
        $image = new Image\Imagick('test.gif', 640, 480);
        $image->setCompression(50);
        $this->assertEquals(50, $image->getCompression());
    }

    public function testSetImageFilter()
    {
        $image = new Image\Imagick('test.gif', 640, 480);
        $image->setImageFilter(\Imagick::FILTER_CUBIC);
        $this->assertEquals(\Imagick::FILTER_CUBIC, $image->getImageFilter());
    }

    public function testSetImageBlur()
    {
        $image = new Image\Imagick('test.gif', 640, 480);
        $image->setImageBlur(5);
        $this->assertEquals(5, $image->getImageBlur());
    }

    public function testLoadException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Imagick();
        $image->load('bad.jpg');
    }

    public function testAdjust()
    {
        $image = new Image\Imagick();
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testAdjustImageNotSet()
    {
        $image = new Image\Imagick();
        $image->setAdjust(new Image\Adjust\Imagick());
        $this->assertInstanceOf('Pop\Image\Adjust\Imagick', $image->adjust());
    }

    public function testDraw()
    {
        $image = new Image\Imagick();
        $this->assertInstanceOf('Pop\Image\Draw\Imagick', $image->draw());
    }

    public function testDrawImageNotSet()
    {
        $image = new Image\Imagick();
        $image->setDraw(new Image\Draw\Imagick());
        $this->assertInstanceOf('Pop\Image\Draw\Imagick', $image->draw());
    }

    public function testEffect()
    {
        $image = new Image\Imagick();
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testEffectImageNotSet()
    {
        $image = new Image\Imagick();
        $image->setEffect(new Image\Effect\Imagick());
        $this->assertInstanceOf('Pop\Image\Effect\Imagick', $image->effect());
    }

    public function testFilter()
    {
        $image = new Image\Imagick();
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testFilterImageNotSet()
    {
        $image = new Image\Imagick();
        $image->setFilter(new Image\Filter\Imagick());
        $this->assertInstanceOf('Pop\Image\Filter\Imagick', $image->filter());
    }

    public function testLayer()
    {
        $image = new Image\Imagick();
        $this->assertInstanceOf('Pop\Image\Layer\Imagick', $image->layer());
    }

    public function testLayerImageNotSet()
    {
        $image = new Image\Imagick();
        $image->setLayer(new Image\Layer\Imagick());
        $this->assertInstanceOf('Pop\Image\Layer\Imagick', $image->layer());
    }

    public function testType()
    {
        $image = new Image\Imagick();
        $this->assertInstanceOf('Pop\Image\Type\Imagick', $image->type());
    }

    public function testTypeImageNotSet()
    {
        $image = new Image\Imagick();
        $image->setType(new Image\Type\Imagick());
        $this->assertInstanceOf('Pop\Image\Type\Imagick', $image->type());
    }

    public function testSetQualityPng()
    {
        $image = new Image\Imagick('test.png', 640, 480);
        $image->setQuality(80);
        $this->assertEquals(80, (int)$image->getQuality());
    }

    public function testResizeToWidth()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->resizeToWidth(320);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResizeToHeight()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->resizeToHeight(240);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResize()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
    }

    public function testScale()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->scale(0.5);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testCrop()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumb()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffset()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbVertical()
    {
        $image = new Image\Imagick('test.jpg', 480, 640);
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffsetVertical()
    {
        $image = new Image\Imagick('test.jpg', 480, 640);
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testRotate()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->rotate(45);
        $this->assertGreaterThan(770, $image->getWidth());
        $this->assertGreaterThan(770, $image->getHeight());
    }

    public function testRotateException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->rotate(45, [255]);
    }

    public function testFlip()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->flip();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testFlop()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->flop();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testConvert()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->convert('gif');
        $this->assertEquals('image/gif', $image->getMime());
        $image->convert('png');
        $this->assertEquals('image/png', $image->getMime());
        $image->convert('jpg');
        $this->assertEquals('image/jpeg', $image->getMime());
    }

    public function testConvertPsd()
    {
        $image = new Image\Imagick('test.psd', 640, 480);
        $this->assertEquals('image/x-photoshop', $image->getMime());
        $image->convert('png');
        $this->assertEquals('image/png', $image->getMime());
    }

    public function testConvertTypeNotAllowedException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->convert('bad');
    }

    public function testConvertCurrentTypeException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->convert('jpg');
    }

    public function testSave()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->setCompression(50);
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
        $image->save(__DIR__ . '/tmp/test-240.jpg');
        $this->assertFileExists(__DIR__ . '/tmp/test-240.jpg');
        unlink(__DIR__ . '/tmp/test-240.jpg');
    }

    /**
     * @runInSeparateProcess
     */
    public function testOutput()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->setCompression(50);
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
        $image->save(__DIR__ . '/tmp/test-240.jpg');

        ob_start();
        $image->output();
        $result = ob_get_clean();

        $image->destroy(true);
        $this->assertFalse(ctype_print($result));
        $this->assertFileNotExists(__DIR__ . '/tmp/test-240.jpg');
    }
    /**
     * @runInSeparateProcess
     */
    public function testToString()
    {
        $image = new Image\Imagick(__DIR__ . '/tmp/test.jpg');
        $image->setCompression(50);
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
        $image->save(__DIR__ . '/tmp/test-240.jpg');

        ob_start();
        echo $image;
        $result = ob_get_clean();

        $image->destroy(true);
        $this->assertFalse(ctype_print($result));
        $this->assertFileNotExists(__DIR__ . '/tmp/test-240.jpg');
    }

}