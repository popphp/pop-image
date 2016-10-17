<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Adapter;

use Pop\Image\Color\ColorInterface;

/**
 * Abstract adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
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
    protected $name = null;

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
     * Image colorspace
     * @var int
     */
    protected $colorspace = 2;

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

        // $image
        if (isset($args[0]) && !is_numeric($args[0]) && file_exists($args[0])) {
            $this->name = $args[0];
            $this->load();
        // $width, $height or $width, $height, $image
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
     * Set the colorspace
     *
     * @param  int $colorspace
     * @return AbstractAdapter
     */
    public function setColorspace($colorspace)
    {
        $colorspace = (int)$colorspace;

        if (($colorspace > 0) && ($colorspace < 4)) {
            $this->colorspace = $colorspace;
        }
        return $this;
    }

    /**
     * Load the image resource from the existing image file
     *
     * @return AbstractAdapter
     */
    abstract public function load();

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
     * @return AbstractAdapter
     */
    abstract public function create();

    /**
     * Resize the image object to the width parameter passed.
     *
     * @param  int $w
     * @return AbstractAdapter
     */
    abstract public function resizeToWidth($w);

    /**
     * Resize the image object to the height parameter passed.
     *
     * @param  int $h
     * @return AbstractAdapter
     */
    abstract public function resizeToHeight($h);

    /**
     * Resize the image object, allowing for the largest dimension to be scaled
     * to the value of the $px argument.
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
     * adjustment of the crop to select a certain area of the image to be
     * cropped.
     *
     * @param  int $px
     * @param  int $offset
     * @return AbstractAdapter
     */
    abstract public function cropThumb($px, $offset = null);

    /**
     * Rotate the image object
     *
     * @param  int            $degrees
     * @param  ColorInterface $bgColor
     * @throws Exception
     * @return Gd
     */
    abstract public function rotate($degrees, ColorInterface $bgColor = null);

    /**
     * Method to flip the image over the x-axis.
     *
     * @return AbstractAdapter
     */
    abstract public function flip();

    /**
     * Method to flip the image over the y-axis.
     *
     * @return AbstractAdapter
     */
    abstract public function flop();

    /**
     * Convert the image object to another format.
     *
     * @param  string $type
     * @throws Exception
     * @return AbstractAdapter
     */
    abstract public function convert($type);
    
}