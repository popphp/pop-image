<?php

namespace Pop\Image\Test;

use Pop\Image;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testCreatePng()
    {
        $image = new Image\Gd('test.png', 640, 480);
        $this->assertEquals('image/png', $image->getMime());
        $image->save(__DIR__ . '/tmp/test.png');
        $this->assertFileExists(__DIR__ . '/tmp/test.png');
        unlink(__DIR__ . '/tmp/test.png');
    }

    public function testCreateGif()
    {
        $image = new Image\Gd('test.gif', 640, 480);
        $this->assertEquals('image/gif', $image->getMime());
        $image->save(__DIR__ . '/tmp/test.gif');
        $this->assertFileExists(__DIR__ . '/tmp/test.gif');
        unlink(__DIR__ . '/tmp/test.gif');
    }

    public function testGetFormats()
    {
        $this->assertEquals(5, count(Image\Gd::getFormats()));
    }

    public function testLoadException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Gd();
        $image->load('bad.jpg');
    }

    public function testAdjust()
    {
        $image = new Image\Gd();
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

    public function testAdjustImageNotSet()
    {
        $image = new Image\Gd();
        $image->setAdjust(new Image\Adjust\Gd());
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
    }

    public function testDraw()
    {
        $image = new Image\Gd();
        $this->assertInstanceOf('Pop\Image\Draw\Gd', $image->draw());
    }

    public function testDrawImageNotSet()
    {
        $image = new Image\Gd();
        $image->setDraw(new Image\Draw\Gd());
        $this->assertInstanceOf('Pop\Image\Draw\Gd', $image->draw());
    }

    public function testEffect()
    {
        $image = new Image\Gd();
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testEffectImageNotSet()
    {
        $image = new Image\Gd();
        $image->setEffect(new Image\Effect\Gd());
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
    }

    public function testFilter()
    {
        $image = new Image\Gd();
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testFilterImageNotSet()
    {
        $image = new Image\Gd();
        $image->setFilter(new Image\Filter\Gd());
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
    }

    public function testLayer()
    {
        $image = new Image\Gd();
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testLayerImageNotSet()
    {
        $image = new Image\Gd();
        $image->setLayer(new Image\Layer\Gd());
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
    }

    public function testType()
    {
        $image = new Image\Gd();
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testTypeImageNotSet()
    {
        $image = new Image\Gd();
        $image->setType(new Image\Type\Gd());
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
    }

    public function testSetQualityPng()
    {
        $image = new Image\Gd('test.png', 640, 480);
        $image->setQuality(80);
        $this->assertEquals(2, (int)$image->getQuality());
    }

    public function testResizeToWidth()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->resizeToWidth(320);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResizeToHeight()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->resizeToHeight(240);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testResize()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
    }

    public function testScale()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->scale(0.5);
        $this->assertEquals(320, $image->getWidth());
        $this->assertEquals(240, $image->getHeight());
    }

    public function testCrop()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->crop(50, 50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumb()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffset()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbVertical()
    {
        $image = new Image\Gd('test.jpg', 480, 640);
        $image->cropThumb(50);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testCropThumbOffsetVertical()
    {
        $image = new Image\Gd('test.jpg', 480, 640);
        $image->cropThumb(50, 10);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testRotate()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->rotate(45);
        $this->assertGreaterThan(770, $image->getWidth());
        $this->assertGreaterThan(770, $image->getHeight());
    }

    public function testRotateException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->rotate(45, [255]);
    }

    public function testFlip()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->flip();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testFlop()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->flop();
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());
    }

    public function testCovert()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->convert('gif');
        $this->assertEquals('image/gif', $image->getMime());
        $image->convert('png');
        $this->assertEquals('image/png', $image->getMime());
        $image->convert('jpg');
        $this->assertEquals('image/jpeg', $image->getMime());
    }

    public function testCovertTypeNotAllowedException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->convert('psd');
    }

    public function testCovertCurrentTypeException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->convert('jpg');
    }

    public function testSave()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
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
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
        $image->save(__DIR__ . '/tmp/test-240.jpg');

        ob_start();
        $image->output();
        $result = ob_get_clean();

        $image->destroy(true);
        $this->assertContains('JPEG', $result);
        $this->assertFileNotExists(__DIR__ . '/tmp/test-240.jpg');
    }

    /**
     * @runInSeparateProcess
     */
    public function testToString()
    {
        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $image->resize(240);
        $this->assertEquals(240, $image->getWidth());
        $this->assertEquals(180, $image->getHeight());
        $image->save(__DIR__ . '/tmp/test-240.jpg');

        ob_start();
        echo $image;
        $result = ob_get_clean();

        $image->destroy(true);
        $this->assertContains('JPEG', $result);
        $this->assertFileNotExists(__DIR__ . '/tmp/test-240.jpg');
    }


}
