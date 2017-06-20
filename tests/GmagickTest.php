<?php

namespace Pop\Image\Test;

use Pop\Image\Gmagick;

class GmagickTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Gmagick is not installed');
        }
    }

    public function testAdapters()
    {
        $adapters = Gmagick::getAvailableAdapters();
        $this->assertTrue(isset($adapters['imagick']));
        $this->assertTrue(is_bool(Gmagick::isAvailable()));
    }

    public function testLoadGmagick()
    {
        $image = Gmagick::load(__DIR__ . '/tmp/test.jpg');
        $this->assertInstanceOf('Pop\Image\Adapter\Gmagick', $image);
    }

    public function testLoadGmagickFromString()
    {
        $image = Gmagick::loadFromString(file_get_contents(__DIR__ . '/tmp/test.jpg'));
        $this->assertInstanceOf('Pop\Image\Adapter\Gmagick', $image);
    }

    public function testCreateGmagick()
    {
        $image = Gmagick::create(640, 480, 'test.jpg');
        $this->assertInstanceOf('Pop\Image\Adapter\Gmagick', $image);
    }

    public function testCreateGmagickIndex()
    {
        $image = Gmagick::createIndex(640, 480, 'test.gif');
        $this->assertInstanceOf('Pop\Image\Adapter\Gmagick', $image);
    }

}
