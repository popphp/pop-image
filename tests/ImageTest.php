<?php

namespace Pop\Image\Test;

use Pop\Image\Image;
use Pop\Image\Gd;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{

    public function testAdapters()
    {
        $adapters = Image::getAvailableAdapters();
        $this->assertTrue(isset($adapters['gd']));
        $this->assertTrue(is_bool(Image::isAvailable('gd')));
        $this->assertTrue(is_bool(Image::isAvailable('imagick')));
    }

    public function testGdAdapters()
    {
        $adapters = Gd::getAvailableAdapters();
        $this->assertTrue(isset($adapters['gd']));
        $this->assertTrue(is_bool(Gd::isAvailable('gd')));
    }

    public function testLoadGd()
    {
        $image = Image::loadGd(__DIR__ . '/tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Adapter\Gd', $image);
    }

    public function testLoadGdFromString()
    {
        $image = Image::loadGdFromString(file_get_contents(__DIR__ . '/tmp/test.jpg'));
        $this->assertInstanceOf('Pop\Image\Adapter\Gd', $image);
    }

    public function testCreateGd()
    {
        $image = Image::createGd(640, 480, 'test.jpg');
        $this->assertInstanceOf('Pop\Image\Adapter\Gd', $image);
    }

    public function testCreateGdIndex()
    {
        $image = Image::createGdIndex(640, 480, 'test.gif');
        $this->assertInstanceOf('Pop\Image\Adapter\Gd', $image);
    }

}
