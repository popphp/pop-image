<?php

namespace Pop\Image\Test\Factory;

use Pop\Image;

class SvgTest extends \PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $image = new Image\Factory\Svg();
        $svg   = $image->create('640px', '480px', 'test.svg');
        $this->assertInstanceOf('Pop\Image\Svg', $svg);
        $svg->save(__DIR__ . '/../tmp/test.svg');
    }

    public function testLoad()
    {
        $image = new Image\Factory\Svg();
        $this->assertInstanceOf('Pop\Image\Svg', $image->load(__DIR__ . '/../tmp/test.svg'));
        unlink(__DIR__ . '/../tmp/test.svg');
    }

}
