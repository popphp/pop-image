<?php

namespace Pop\Image\Test\Factory;

use Pop\Image;

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testLoad()
    {
        $image = new Image\Factory\Gd();
        $this->assertInstanceOf('Pop\Image\Gd', $image->load(__DIR__ . '/../tmp/test.jpg'));
    }

    public function testCreate()
    {
        $image = new Image\Factory\Gd();
        $this->assertInstanceOf('Pop\Image\Gd', $image->create(640, 480, 'test.jpg'));
    }

}
