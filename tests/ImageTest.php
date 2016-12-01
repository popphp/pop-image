<?php

namespace Pop\Image\Test;

use Pop\Image\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{

    public function testAdapters()
    {
        $adapters = Image::getAvailableAdapters();
        $this->assertTrue(isset($adapters['gd']));
        $this->assertTrue(is_bool(Image::isAvailable('imagick')));
        $this->assertTrue(is_bool(Image::isAvailable('gmagick')));
    }

}
