<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image;

/**
 * Image captcha class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
class Captcha
{

    /**
     * CAPTCHA URL
     * @var string
     */
    protected $url = null;

    /**
     * CAPTCHA answer length
     * @var string
     */
    protected $answer = null;

    /**
     * CAPTCHA length
     * @var string
     */
    protected $length = 4;

    /**
     * CAPTCHA uppercase flag
     * @var boolean
     */
    protected $uppercase = true;

    /**
     * CAPTCHA expiration
     * @var int
     */
    protected $expire = 300;

    /**
     * CAPTCHA reload text
     * @var string
     */
    protected $reload = 'Reload';

    /**
     * CAPTCHA image
     * @var Adapter\Gd
     */
    protected $image = null;

    /**
     * Current token data
     * @var array
     */
    protected $token = [];

    /**
     * CAPTCHA image config
     * @var array
     */
    protected $config = [
        'adapter'     => 'Gd',
        'width'       => 71,
        'height'      => 26,
        'lineSpacing' => 5,
        'lineColor'   => [175, 175, 175],
        'textColor'   => [0, 0, 0],
        'font'        => null,
        'size'        => 0,
        'rotate'      => 0
    ];

    /**
     * Constructor
     *
     * Instantiate the captcha image object
     *
     * @param  string $url
     * @param  int    $expire
     * @param  array  $config
     */
    public function __construct($url, $expire = 300, array $config = null)
    {
        $this->setUrl($url);
        $this->setExpire($expire);

        if (null !== $config) {
            $this->setConfig($config);
        }

        // Start a session.
        if (session_id() == '') {
            session_start();
        }

        // If token does not exist, create one
        if (!isset($_SESSION['pop_captcha']) || (isset($_GET['captcha']) && ((int)$_GET['captcha'] == 1))) {
            $this->createNewToken();
        // Else, retrieve existing token
        } else {
            $this->token = unserialize($_SESSION['pop_captcha']);

            // Check to see if the token has expired
            if ($this->token['expire'] > 0) {
                if (($this->token['expire'] + $this->token['start']) < time()) {
                    $this->createNewToken();
                }
            }
        }
    }

    /**
     * Set CAPTCHA URL
     *
     * @param  string $url
     * @return Captcha
     */
    public function setUrl($url)
    {
        $this->url = str_replace(['?captcha=1', '&captcha=1'], ['', ''], $url);
        return $this;
    }

    /**
     * Set CAPTCHA expiration
     *
     * @param  int $expire
     * @return Captcha
     */
    public function setExpire($expire)
    {
        $this->expire = (int)$expire;
        return $this;
    }

    /**
     * Set CAPTCHA answer
     *
     * @param  string $answer
     * @return Captcha
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }

    /**
     * Set CAPTCHA answer length
     *
     * @param  int $length
     * @return Captcha
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * Set CAPTCHA answer case
     *
     * @param  boolean $uppercase
     * @return Captcha
     */
    public function setUppercase($uppercase)
    {
        $this->uppercase = (bool)$uppercase;
        return $this;
    }

    /**
     * Set CAPTCHA reload text
     *
     * @param  string $reload
     * @return Captcha
     */
    public function setReload($reload)
    {
        $this->reload = $reload;
        return $this;
    }

    /**
     * Set CAPTCHA image config
     *
     * @param  array $config
     * @return Captcha
     */
    public function setConfig(array $config)
    {
        if (isset($config['adapter'])) {
            $this->config['adapter'] = $config['adapter'];
        }
        if (isset($config['width'])) {
            $this->config['width'] = $config['width'];
        }
        if (isset($config['height'])) {
            $this->config['height'] = $config['height'];
        }
        if (isset($config['lineSpacing'])) {
            $this->config['lineSpacing'] = $config['lineSpacing'];
        }
        if (isset($config['lineColor'])) {
            $this->config['lineColor'] = $config['lineColor'];
        }
        if (isset($config['textColor'])) {
            $this->config['textColor'] = $config['textColor'];
        }
        if (isset($config['font'])) {
            $this->config['font'] = $config['font'];
        }
        if (isset($config['size'])) {
            $this->config['size'] = $config['size'];
        }
        if (isset($config['rotate'])) {
            $this->config['rotate'] = $config['rotate'];
        }
        return $this;
    }

    /**
     * Get CAPTCHA URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get CAPTCHA expiration
     *
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Get CAPTCHA answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Get CAPTCHA answer length
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Get CAPTCHA answer case
     *
     * @return boolean
     */
    public function isUppercase()
    {
        return $this->uppercase;
    }

    /**
     * Get CAPTCHA reload text
     *
     * @return string
     */
    public function getReload()
    {
        return $this->reload;
    }

    /**
     * Get CAPTCHA image config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get CAPTCHA image
     *
     * @return Adapter\Gd
     */
    public function getImage()
    {
        if (null === $this->image) {
            $this->createImage();
        }
        return $this->image;
    }

    /**
     * Get CAPTCHA image HTML
     *
     * @return string
     */
    public function getImageHtml()
    {
        if (null === $this->image) {
            $this->createImage();
        }
        return (isset($this->token['captcha'])) ? $this->token['captcha'] : '';
    }

    /**
     * Get CAPTCHA token
     *
     * @return array
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Create CAPTCHA token
     *
     * @return Captcha
     */
    public function createNewToken()
    {
        $captcha = '<img id="pop-captcha-image" class="pop-captcha-image" src="' . $this->url . '" />' .
            '<a class="pop-captcha-reload" href="#" onclick="document.getElementById(\'pop-captcha-image\').src = \'' .
            $this->url . '?captcha=1\'; return false;">' . $this->reload . '</a>';

        $answer = (null === $this->answer) ? $this->random($this->length, true) : $this->answer;

        $this->token = [
            'captcha' => $captcha,
            'answer'  => $answer,
            'expire'  => (int)$this->expire,
            'start'   => time()
        ];
        $_SESSION['pop_captcha'] = serialize($this->token);
        return $this;
    }

    /**
     * Create CAPTCHA image
     *
     * @return Captcha
     */
    public function createImage()
    {
        if (($this->config['adapter'] == 'Gmagick') || ($this->config['adapter'] == 'Imagick')) {
            $adapterClass = 'Pop\Image\\' . $this->config['adapter'];
            $borderSize   = 1.0;
            $fontSize     = 14;
            $xyAdjust     = 1;
        } else {
            $adapterClass = 'Pop\Image\Gd';
            $borderSize   = 0.5;
            $fontSize     = 5;
            $xyAdjust     = 0;
        }

        $this->image = $adapterClass::create($this->config['width'], $this->config['height'], 'captcha.gif');
        $this->image->effect()->fill(new Color\Rgb(255, 255, 255));
        $this->image->draw()->setStrokeColor(
            new Color\Rgb($this->config['lineColor'][0], $this->config['lineColor'][1], $this->config['lineColor'][2])
        );

        // Draw background grid
        for ($y = $this->config['lineSpacing']; $y <= $this->config['height']; $y += $this->config['lineSpacing']) {
            $this->image->draw()->line(0, $y -  $xyAdjust, $this->config['width'], $y -  $xyAdjust);
        }

        for ($x = $this->config['lineSpacing']; $x <= $this->config['width']; $x += $this->config['lineSpacing']) {
            $this->image->draw()->line($x -  $xyAdjust, 0, $x -  $xyAdjust, $this->config['height']);
        }

        $this->image->effect()->border(
            new Color\Rgb($this->config['textColor'][0], $this->config['textColor'][1], $this->config['textColor'][2]), $borderSize
        );
        $this->image->type()->setFillColor(
            new Color\Rgb($this->config['textColor'][0], $this->config['textColor'][1], $this->config['textColor'][2])
        );

        if (null === $this->config['font']) {
            $this->image->type()->size($fontSize);
            $textX = round(($this->config['width'] - ($this->length * 10)) / 2);
            $textY = ($adapterClass != 'Pop\Image\Gd') ?
                $this->config['height'] - (round(($this->config['height'] - $fontSize) / 2)) :
                round(($this->config['height'] - 16) / 2);
        } else {
            $this->image->type()->font($this->config['font'])
                 ->size($this->config['size']);
            $textX = round(($this->config['width'] - ($this->length * ($this->config['size'] / 1.5))) / 2);
            $textY = round($this->config['height'] -
                (($this->config['height'] - $this->config['size']) / 2) + ((int)$this->config['rotate'] / 2));
        }

        $this->image->type()->xy($textX, $textY)
             ->text($this->token['answer']);

        return $this;
    }

    /**
     * Create random alphanumeric string
     *
     * @param  int     $length
     * @param  boolean $case
     * @return string
     */
    public function random($length = 8, $case = false)
    {
        $chars = [
            0 => (($case) ? str_split('ABCDEFGHJKMNPQRSTUVWXYZ') : str_split('abcdefghjkmnpqrstuvwxyz')),
            1 => str_split('23456789')
        ];
        $indices = [0, 1];
        $str     = '';

        for ($i = 0; $i < (int)$length; $i++) {
            $index = $indices[rand(0, (count($indices) - 1))];
            $subIndex = rand(0, (count($chars[$index]) - 1));
            $str .= $chars[$index][$subIndex];
        }

        return $str;
    }

    /**
     * Print out the image
     *
     * @return string
     */
    public function __toString()
    {
        if (null === $this->image) {
            $this->createImage();
        }
        return (string)$this->getImage();
    }

}