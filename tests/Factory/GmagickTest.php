<?php

namespace Pop\Image\Test\Factory;

use Pop\Image;

class GmagickTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Gmagick is not installed');
        }
    }

    public function testLoad()
    {
        $image = new Image\Factory\Gmagick();
        $this->assertInstanceOf('Pop\Image\Gmagick', $image->load(__DIR__ . '/../tmp/test.jpg'));
    }

    public function testCreate()
    {
        $image = new Image\Factory\Gmagick();
        $this->assertInstanceOf('Pop\Image\Gmagick', $image->create(640, 480, 'test.jpg'));
    }

}
