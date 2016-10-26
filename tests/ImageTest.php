<?php

namespace Pop\Image\Test;

use Pop\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $this->assertInstanceOf('Pop\Image\Gd', $image);
        $this->assertEquals('test.jpg', $image->getBasename());

        $image = new Image\Gd(640, 480, 'test.jpg');
        $this->assertInstanceOf('Pop\Image\Gd', $image);
        $this->assertEquals('test.jpg', $image->getBasename());

        $image = new Image\Gd(__DIR__ . '/tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Gd', $image);
        $this->assertEquals('test.jpg', $image->getBasename());
        $this->assertTrue(is_resource($image->resource()));
        $this->assertEquals(__DIR__ . '/tmp/test.jpg', $image->getFullPath());
        $this->assertEquals(__DIR__ . '/tmp', $image->getDir());
        $this->assertEquals('test', $image->getFilename());
        $this->assertEquals('jpg', $image->getExtension());
        $this->assertGreaterThan(27000, $image->getSize());
        $this->assertEquals('image/jpeg', $image->getMime());
        $this->assertEquals(640, $image->getWidth());
        $this->assertEquals(480, $image->getHeight());

        $image->setDraw(new Image\Draw\Gd($image));
        $this->assertInstanceOf('Pop\Image\Draw\Gd', $image->draw());
        $this->assertInstanceOf('Pop\Image\Draw\Gd', $image->draw);

        $image->setEffect(new Image\Effect\Gd($image));
        $image->setBackgroundColor(255, 0, 0);
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect());
        $this->assertInstanceOf('Pop\Image\Effect\Gd', $image->effect);

        $image->setType(new Image\Type\Gd($image));
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type());
        $this->assertInstanceOf('Pop\Image\Type\Gd', $image->type);

        $image->setAdjust(new Image\Adjust\Gd($image));
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust());
        $this->assertInstanceOf('Pop\Image\Adjust\Gd', $image->adjust);

        $image->setFilter(new Image\Filter\Gd($image));
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter());
        $this->assertInstanceOf('Pop\Image\Filter\Gd', $image->filter);

        $image->setLayer(new Image\Layer\Gd($image));
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer());
        $this->assertInstanceOf('Pop\Image\Layer\Gd', $image->layer);

        $this->assertNull($image->noobject);

        $this->assertEquals(5, count($image->getAllowedTypes()));
        $this->assertInstanceOf('ArrayObject', $image->info());
        $this->assertTrue(is_string($image->version()));
    }

    public function testConstructorTypeNotAllowedException()
    {
        $this->expectException('Pop\Image\Exception');
        $image = new Image\Gd('test.bad', 640, 480);
    }

    public function testAdapters()
    {
        $adapters = Image\Gd::getAvailableAdapters();
        $this->assertTrue(isset($adapters['gd']));
        $this->assertTrue(is_bool(Image\Gd::isAvailable('imagick')));
        $this->assertTrue(is_bool(Image\Gd::isAvailable('gmagick')));
    }

    public function testSetQuality()
    {
        $image = new Image\Gd('test.jpg', 640, 480);
        $image->setQuality(80);
        $this->assertEquals(80, $image->getQuality());
    }

}
