<?php

namespace Pop\Image\Test;

use Pop\Image\Imagick;
use PHPUnit\Framework\TestCase;

class ImagickTest extends TestCase
{

    public function testAdapters()
    {
        $adapters = Imagick::getAvailableAdapters();
        $this->assertTrue(isset($adapters['imagick']));
        $this->assertTrue(is_bool(Imagick::isAvailable()));
    }

    public function testLoadImagick()
    {
        $image = Imagick::load(__DIR__ . '/tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Adapter\Imagick', $image);
    }

    public function testLoadImagickFromString()
    {
        $image = Imagick::loadFromString(file_get_contents(__DIR__ . '/tmp/test.jpg'));
        $this->assertInstanceOf('Pop\Image\Adapter\Imagick', $image);
    }

    public function testCreateImagick()
    {
        $image = Imagick::create(640, 480, 'test.jpg');
        $this->assertInstanceOf('Pop\Image\Adapter\Imagick', $image);
    }

    public function testCreateImagickIndex()
    {
        $image = Imagick::createIndex(640, 480, 'test.gif');
        $this->assertInstanceOf('Pop\Image\Adapter\Imagick', $image);
    }

    public function testGetNumberImages()
    {
        $image = Imagick::create(640, 480, 'test.jpg');
        $this->assertEquals(1, $image->getNumberOfImages());
    }

}
