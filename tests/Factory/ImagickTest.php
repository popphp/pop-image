<?php

namespace Pop\Image\Test\Factory;

use Pop\Image;

class ImagickTest extends \PHPUnit_Framework_TestCase
{

    public function testLoad()
    {
        $image = new Image\Factory\Imagick();
        $this->assertInstanceOf('Pop\Image\Imagick', $image->load(__DIR__ . '/../tmp/test.jpg'));
    }

    public function testCreate()
    {
        $image = new Image\Factory\Imagick();
        $this->assertInstanceOf('Pop\Image\Imagick', $image->create(640, 480, 'test.jpg'));
    }

}
