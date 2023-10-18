<?php

namespace Pop\Image\Test;

use Pop\Image\Captcha;
use PHPUnit\Framework\TestCase;

class CaptchaTest extends TestCase
{

    public function testConstructor1()
    {
        $captcha = new Captcha('http://localhost/', 300, [
            'adapter'     => 'Gd',
            'width'       => 100,
            'height'      => 40,
            'lineSpacing' => 6,
            'lineColor'   => [175, 175, 175],
            'textColor'   => [0, 0, 0],
            'font'        => null,
            'size'        => 0,
            'rotate'      => 0
        ]);
        $this->assertInstanceOf('Pop\Image\Captcha', $captcha);
    }


    public function testConstructor2()
    {
        $captcha = '<img id="pop-captcha-image" class="pop-captcha-image" src="/uri" />' .
            '<a class="pop-captcha-reload" href="#" onclick="document.getElementById(\'pop-captcha-image\').src = \'' .
            '/url?captcha=1\'; return false;">Reload</a>';

        $token = [
            'captcha' => $captcha,
            'answer'  => 'YH45',
            'expire'  => 300,
            'start'   => time()
        ];

        $_SESSION['pop_captcha'] = serialize($token);

        $captcha = new Captcha('http://localhost/', 300, [
            'adapter'     => 'Gd',
            'width'       => 100,
            'height'      => 40,
            'lineSpacing' => 6,
            'lineColor'   => [175, 175, 175],
            'textColor'   => [0, 0, 0],
            'font'        => null,
            'size'        => 0,
            'rotate'      => 0
        ]);
        $this->assertInstanceOf('Pop\Image\Captcha', $captcha);
        $this->assertTrue(is_array($captcha->getToken()));
    }

    public function testGettersAndSetters1()
    {
        $captcha = new Captcha('http://localhost/', 300, [
            'adapter'     => 'Gd',
            'width'       => 100,
            'height'      => 40,
            'lineSpacing' => 6,
            'lineColor'   => [175, 175, 175],
            'textColor'   => [0, 0, 0],
            'font'        => null,
            'size'        => 0,
            'rotate'      => 0
        ]);

        $captcha->setAnswer('YUI92')
            ->setLength(5)
            ->setUppercase(true)
            ->setReload('Refresh');

        $this->assertEquals('http://localhost/', $captcha->getUrl());
        $this->assertEquals(300, $captcha->getExpire());
        $this->assertEquals('YUI92', $captcha->getAnswer());
        $this->assertEquals(5, $captcha->getLength());
        $this->assertEquals('Refresh', $captcha->getReload());
        $this->assertTrue($captcha->isUppercase());
        $this->assertTrue(is_array($captcha->getConfig()));
        $this->assertInstanceOf('Pop\Image\Adapter\Gd', $captcha->getImage());
        $this->assertTrue(str_contains($captcha->getImageHtml(), '<img id="pop-captcha-image" class="pop-captcha-image" src="'));
    }

    public function testGettersAndSetters2()
    {
        $captcha = new Captcha('http://localhost/', 300, [
            'adapter'     => 'Imagick',
            'width'       => 100,
            'height'      => 40,
            'lineSpacing' => 6,
            'lineColor'   => [175, 175, 175],
            'textColor'   => [0, 0, 0],
            'font'        => null,
            'size'        => 0,
            'rotate'      => 0
        ]);

        $captcha->setAnswer('YUI92')
            ->setLength(5)
            ->setUppercase(true)
            ->setReload('Refresh');

        $this->assertEquals('http://localhost/', $captcha->getUrl());
        $this->assertEquals(300, $captcha->getExpire());
        $this->assertEquals('YUI92', $captcha->getAnswer());
        $this->assertEquals(5, $captcha->getLength());
        $this->assertEquals('Refresh', $captcha->getReload());
        $this->assertTrue($captcha->isUppercase());
        $this->assertTrue(is_array($captcha->getConfig()));
        $this->assertInstanceOf('Pop\Image\Adapter\Imagick', $captcha->getImage());
        $this->assertTrue(str_contains($captcha->getImageHtml(), '<img id="pop-captcha-image" class="pop-captcha-image" src="'));
    }

    public function testToString()
    {
        $captcha = new Captcha('http://localhost/', 300, [
            'adapter'     => 'Imagick',
            'width'       => 100,
            'height'      => 40,
            'lineSpacing' => 6,
            'lineColor'   => [175, 175, 175],
            'textColor'   => [0, 0, 0],
            'font'        => null,
            'size'        => 0,
            'rotate'      => 0
        ]);

        $captcha->setAnswer('YUI92')
            ->setLength(5)
            ->setUppercase(true)
            ->setReload('Refresh');

        ob_start();
        echo $captcha;
        $result = ob_end_clean();

        $this->assertTrue($result);

    }

}
