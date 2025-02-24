<?php
/**
 * Pop PHP Framework (https://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image;

use Pop\Color\Color;

/**
 * Image captcha class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.1
 */
class Captcha
{

    /**
     * CAPTCHA URL
     * @var ?string
     */
    protected ?string $url = null;

    /**
     * CAPTCHA answer length
     * @var ?string
     */
    protected ?string $answer = null;

    /**
     * CAPTCHA length
     * @var int
     */
    protected int $length = 4;

    /**
     * CAPTCHA uppercase flag
     * @var bool
     */
    protected bool $uppercase = true;

    /**
     * CAPTCHA expiration
     * @var int
     */
    protected int $expire = 300;

    /**
     * CAPTCHA reload text
     * @var string
     */
    protected string $reload = 'Reload';

    /**
     * CAPTCHA image
     * @var ?Adapter\AbstractAdapter
     */
    protected ?Adapter\AbstractAdapter $image = null;

    /**
     * Current token data
     * @var array
     */
    protected array $token = [];

    /**
     * CAPTCHA image config
     * @var array
     */
    protected array $config = [
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
     * @param  ?array $config
     */
    public function __construct(string $url, int $expire = 300, ?array $config = null)
    {
        $this->setUrl($url);
        $this->setExpire($expire);

        if ($config !== null) {
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
    public function setUrl(string $url): Captcha
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
    public function setExpire(int $expire): Captcha
    {
        $this->expire = $expire;
        return $this;
    }

    /**
     * Set CAPTCHA answer
     *
     * @param  string $answer
     * @return Captcha
     */
    public function setAnswer(string $answer): Captcha
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
    public function setLength(int $length): Captcha
    {
        $this->length = $length;
        return $this;
    }

    /**
     * Set CAPTCHA answer case
     *
     * @param  bool $uppercase
     * @return Captcha
     */
    public function setUppercase(bool $uppercase): Captcha
    {
        $this->uppercase = $uppercase;
        return $this;
    }

    /**
     * Set CAPTCHA reload text
     *
     * @param  string $reload
     * @return Captcha
     */
    public function setReload(string $reload): Captcha
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
    public function setConfig(array $config): Captcha
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
     * @return string|null
     */
    public function getUrl(): string|null
    {
        return $this->url;
    }

    /**
     * Get CAPTCHA expiration
     *
     * @return int
     */
    public function getExpire(): int
    {
        return $this->expire;
    }

    /**
     * Get CAPTCHA answer
     *
     * @return string|null
     */
    public function getAnswer(): string|null
    {
        return $this->answer;
    }

    /**
     * Get CAPTCHA answer length
     *
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * Get CAPTCHA answer case
     *
     * @return bool
     */
    public function isUppercase(): bool
    {
        return $this->uppercase;
    }

    /**
     * Get CAPTCHA reload text
     *
     * @return string
     */
    public function getReload(): string
    {
        return $this->reload;
    }

    /**
     * Get CAPTCHA image config
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get CAPTCHA image
     *
     * @return Adapter\AbstractAdapter|null
     */
    public function getImage(): Adapter\AbstractAdapter|null
    {
        if ($this->image === null) {
            $this->createImage();
        }
        return $this->image;
    }

    /**
     * Get CAPTCHA image HTML
     *
     * @return string
     */
    public function getImageHtml(): string
    {
        if ($this->image === null) {
            $this->createImage();
        }
        return (isset($this->token['captcha'])) ? $this->token['captcha'] : '';
    }

    /**
     * Get CAPTCHA token
     *
     * @return array
     */
    public function getToken(): array
    {
        return $this->token;
    }

    /**
     * Create CAPTCHA token
     *
     * @return Captcha
     */
    public function createNewToken(): Captcha
    {
        $captcha = '<img id="pop-captcha-image" class="pop-captcha-image" src="' . $this->url . '" />' .
            '<a class="pop-captcha-reload" href="#" onclick="document.getElementById(\'pop-captcha-image\').src = \'' .
            $this->url . '?captcha=1\'; return false;">' . $this->reload . '</a>';

        $this->token = [
            'captcha' => $captcha,
            'answer'  => ($this->answer === null) ? $this->random($this->length, true) : $this->answer,
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
    public function createImage(): Captcha
    {
        if ($this->config['adapter'] == 'Imagick') {
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

        if ($this->config['font'] === null) {
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
     * @param  int  $length
     * @param  bool $case
     * @return string
     */
    public function random(int $length = 8, bool $case = false)
    {
        $chars = [
            0 => (($case) ? str_split('ABCDEFGHJKMNPQRSTUVWXYZ') : str_split('abcdefghjkmnpqrstuvwxyz')),
            1 => str_split('23456789')
        ];
        $indices = [0, 1];
        $str     = '';

        for ($i = 0; $i < $length; $i++) {
            $index    = $indices[rand(0, (count($indices) - 1))];
            $subIndex = rand(0, (count($chars[$index]) - 1));
            $str     .= $chars[$index][$subIndex];
        }

        return $str;
    }

    /**
     * Print out the image
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($this->image === null) {
            $this->createImage();
        }
        return (string)$this->getImage();
    }

}
