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
namespace Pop\Image\Adapter;

use Pop\Image\Adjust;
use Pop\Image\Color;
use Pop\Image\Draw;
use Pop\Image\Effect;
use Pop\Image\Filter;
use Pop\Image\Layer;
use Pop\Image\Type;

/**
 * Abstract adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
abstract class AbstractAdapter
{

    /**
     * Colorspace constants
     */
    const IMAGE_GRAY = 1;
    const IMAGE_RGB  = 2;
    const IMAGE_CMYK = 3;

    /**
     * Image resource
     * @var mixed
     */
    protected $resource = null;

    /**
     * Image name
     * @var string
     */
    protected $name = 'pop-image.jpg';

    /**
     * Image width
     * @var int
     */
    protected $width = 640;

    /**
     * Image height
     * @var int
     */
    protected $height = 480;

    /**
     * Image format
     * @var string
     */
    protected $format = 'jpg';

    /**
     * Image colorspace
     * @var int
     */
    protected $colorspace = 2;

    /**
     * Index color flag
     * @var boolean
     */
    protected $indexed = false;

    /**
     * EXIF data
     * @var array
     */
    protected $exif = [];

    /**
     * Image adjust object
     * @var Adjust\AdjustInterface
     */
    protected $adjust = null;

    /**
     * Image draw object
     * @var Draw\DrawInterface
     */
    protected $draw = null;

    /**
     * Image effect object
     * @var Effect\EffectInterface
     */
    protected $effect = null;

    /**
     * Image filter object
     * @var Filter\FilterInterface
     */
    protected $filter = null;

    /**
     * Image layer object
     * @var Layer\LayerInterface
     */
    protected $layer = null;

    /**
     * Image type object
     * @var Type\TypeInterface
     */
    protected $type = null;

    /**
     * Constructor
     *
     * Instantiate an image object based on either a pre-existing image
     * file on disk, or a new image file.
     *
     */
    public function __construct()
    {
        $args = func_get_args();

        $this->createResource();

        // $image
        if (isset($args[0]) && !is_numeric($args[0]) && file_exists($args[0])) {
            $this->name = $args[0];
            $this->load();
        // $width, $height, $name
        } else if ((count($args) >= 2) && is_numeric($args[0]) && is_numeric($args[1])) {
            $this->width  = $args[0];
            $this->height = $args[1];
            if (isset($args[2]) && !is_numeric($args[2])) {
                $this->name = $args[2];
            }
            $this->create();
        }
    }

    /**
     * Create the image resource
     *
     * @return void
     */
    abstract public function createResource();

    /**
     * Get the image resource
     *
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Determine if there is an image resource
     *
     * @return boolean
     */
    public function hasResource()
    {
        return (null !== $this->resource);
    }

    /**
     * Get the image name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the image width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get the image height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Get the colorspace
     *
     * @return int
     */
    public function getColorspace()
    {
        return $this->colorspace;
    }

    /**
     * Determine if the image is index color
     *
     * @return boolean
     */
    public function isIndexed()
    {
        return $this->indexed;
    }

    /**
     * Get the image format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Get the image EXIF data
     *
     * @return array
     */
    public function getExif()
    {
        return $this->exif;
    }

    /**
     * Determine if the image is grayscale
     *
     * @return boolean
     */
    public function isGray()
    {
        return ($this->colorspace == self::IMAGE_GRAY);
    }

    /**
     * Determine if the image is RGB
     *
     * @return boolean
     */
    public function isRgb()
    {
        return ($this->colorspace == self::IMAGE_RGB);
    }

    /**
     * Determine if the image is CMYK
     *
     * @return boolean
     */
    public function isCmyk()
    {
        return ($this->colorspace == self::IMAGE_CMYK);
    }

    /**
     * Set the image adjust object
     *
     * @param  Adjust\AdjustInterface $adjust
     * @return AbstractAdapter
     */
    public function setAdjust(Adjust\AdjustInterface $adjust)
    {
        $this->adjust = $adjust;
        return $this;
    }

    /**
     * Set the image draw object
     *
     * @param  Draw\DrawInterface $draw
     * @return AbstractAdapter
     */
    public function setDraw(Draw\DrawInterface $draw)
    {
        $this->draw = $draw;
        return $this;
    }

    /**
     * Set the image effect object
     *
     * @param  Effect\EffectInterface $effect
     * @return AbstractAdapter
     */
    public function setEffect(Effect\EffectInterface $effect)
    {
        $this->effect = $effect;
        return $this;
    }

    /**
     * Set the image filter object
     *
     * @param  Filter\FilterInterface $filter
     * @return AbstractAdapter
     */
    public function setFilter(Filter\FilterInterface $filter)
    {
        $this->filter = $filter;
        return $this;
    }
    /**
     * Set the image layer object
     *
     * @param  Layer\LayerInterface $layer
     * @return AbstractAdapter
     */
    public function setLayer(Layer\LayerInterface $layer)
    {
        $this->layer = $layer;
        return $this;
    }

    /**
     * Set the image type object
     *
     * @param  Type\TypeInterface $type
     * @return AbstractAdapter
     */
    public function setType(Type\TypeInterface $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Send image headers the image
     *
     * @param  string  $to
     * @param  boolean $download
     * @param  array   $additionalHeaders
     * @return void
     */
    public function sendHeaders($to = null, $download = false, array $additionalHeaders = [])
    {
        if (null === $to) {
            $to = (null !== $this->name) ? basename($this->name) : 'pop-image.' . $this->format;
        }

        // Determine if the force download argument has been passed.
        $headers = [
            'Content-type'        => 'image/' . (($this->format == 'jpg') ? 'jpeg' : $this->format),
            'Content-disposition' => (($download) ? 'attachment; ' : null) . 'filename=' . $to
        ];

        if (!empty($additionalHeaders)) {
            $headers = $headers + $additionalHeaders;
        }

        // Send the headers and output the image
        if (!headers_sent()) {
            header('HTTP/1.1 200 OK');
            foreach ($headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }
    }

    /**
     * Magic get method to return a manipulation object
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'adjust':
                return $this->adjust();
            case 'filter':
                return $this->filter();
            case 'layer':
                return $this->layer();
            case 'draw':
                return $this->draw();
            case 'effect':
                return $this->effect();
            case 'type':
                return $this->type();
            default:
                return null;
        }
    }

    /**
     * Load the image resource from the existing image file
     *
     * @param  string $name
     * @return AbstractAdapter
     */
    abstract public function load($name = null);

    /**
     * Load the image resource from data
     *
     * @param  string $data
     * @param  string $name
     * @return AbstractAdapter
     */
    abstract public function loadFromString($data, $name = null);

    /**
     * Create a new image resource
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $name
     * @return AbstractAdapter
     */
    abstract public function create($width = null, $height = null, $name = null);

    /**
     * Create a new indexed image resource
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $name
     * @return AbstractAdapter
     */
    abstract public function createIndex($width = null, $height = null, $name = null);

    /**
     * Resize the image object to the width parameter passed
     *
     * @param  int $w
     * @return AbstractAdapter
     */
    abstract public function resizeToWidth($w);

    /**
     * Resize the image object to the height parameter passed
     *
     * @param  int $h
     * @return AbstractAdapter
     */
    abstract public function resizeToHeight($h);

    /**
     * Resize the image object, allowing for the largest dimension
     * to be scaled to the value of the $px argument.
     *
     * @param  int $px
     * @return AbstractAdapter
     */
    abstract public function resize($px);

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument.
     *
     * @param  float $scale
     * @return AbstractAdapter
     */
    abstract public function scale($scale);

    /**
     * Crop the image object to a image whose dimensions are based on the
     * value of the $wid and $hgt argument. The optional $x and $y arguments
     * allow for the adjustment of the crop to select a certain area of the
     * image to be cropped.
     *
     * @param  int $w
     * @param  int $h
     * @param  int $x
     * @param  int $y
     * @return AbstractAdapter
     */
    abstract public function crop($w, $h, $x = 0, $y = 0);

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $offset argument allows for the
     * adjustment of the crop to select a certain area of the image to be cropped.
     *
     * @param  int $px
     * @param  int $offset
     * @return AbstractAdapter
     */
    abstract public function cropThumb($px, $offset = null);

    /**
     * Rotate the image object
     *
     * @param  int                  $degrees
     * @param  Color\ColorInterface $bgColor
     * @throws Exception
     * @return Gd
     */
    abstract public function rotate($degrees, Color\ColorInterface $bgColor = null);

    /**
     * Method to flip the image over the x-axis
     *
     * @return AbstractAdapter
     */
    abstract public function flip();

    /**
     * Method to flip the image over the y-axis
     *
     * @return AbstractAdapter
     */
    abstract public function flop();

    /**
     * Get the image adjust object
     *
     * @return Adjust\AdjustInterface
     */
    abstract public function adjust();

    /**
     * Get the image filter object
     *
     * @return Filter\FilterInterface
     */
    abstract public function filter();

    /**
     * Get the image layer object
     *
     * @return Layer\LayerInterface
     */
    abstract public function layer();

    /**
     * Get the image draw object
     *
     * @return Draw\DrawInterface
     */
    abstract public function draw();

    /**
     * Get the image effect object
     *
     * @return Effect\EffectInterface
     */
    abstract public function effect();

    /**
     * Get the image type object
     *
     * @return Type\TypeInterface
     */
    abstract public function type();

    /**
     * Convert the image object to another format
     *
     * @param  string $type
     * @throws Exception
     * @return AbstractAdapter
     */
    abstract public function convert($type);

    /**
     * Write the image object to a file on disk
     *
     * @param  string $to
     * @param  int    $quality
     * @throws Exception
     * @return void
     */
    abstract public function writeToFile($to = null, $quality = 100);

    /**
     * Output the image object directly to HTTP
     *
     * @param  int     $quality
     * @param  string  $to
     * @param  boolean $download
     * @param  boolean $sendHeaders
     * @throws Exception
     * @return void
     */
    abstract public function outputToHttp($quality = 100, $to = null, $download = false, $sendHeaders = true);

    /**
     * Destroy the image object and the related image file directly
     *
     * @param  boolean $delete
     * @return void
     */
    abstract public function destroy($delete = false);

    /**
     * Create and return a color.
     *
     * @param  Color\ColorInterface $color
     * @param  int                  $alpha
     * @throws Exception
     * @return mixed
     */
    abstract public function createColor(Color\ColorInterface $color = null, $alpha = 100);

    /**
     * Output the image
     *
     * @return string
     */
    abstract public function __toString();

}