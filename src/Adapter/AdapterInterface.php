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
 * Adapter interface
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
interface AdapterInterface
{

    /**
     * Create the image resource
     *
     * @return void
     */
    public function createResource();

    /**
     * Get the image resource
     *
     * @return resource
     */
    public function getResource();

    /**
     * Determine if there is an image resource
     *
     * @return boolean
     */
    public function hasResource();

    /**
     * Get the image name
     *
     * @return string
     */
    public function getName();

    /**
     * Get the image width
     *
     * @return int
     */
    public function getWidth();

    /**
     * Get the image height
     *
     * @return int
     */
    public function getHeight();

    /**
     * Get the colorspace
     *
     * @return int
     */
    public function getColorspace();

    /**
     * Determine if the image is index color
     *
     * @return boolean
     */
    public function isIndexed();

    /**
     * Get the image type
     *
     * @return string
     */
    public function getType();

    /**
     * Get the image EXIF data
     *
     * @return array
     */
    public function getExif();

    /**
     * Determine if the image is grayscale
     *
     * @return boolean
     */
    public function isGray();

    /**
     * Determine if the image is RGB
     *
     * @return boolean
     */
    public function isRgb();

    /**
     * Determine if the image is CMYK
     *
     * @return boolean
     */
    public function isCmyk();

    /**
     * Set the image adjust object
     *
     * @param  Adjust\AdjustInterface $adjust
     * @return AdapterInterface
     */
    public function setAdjust(Adjust\AdjustInterface $adjust);

    /**
     * Set the image draw object
     *
     * @param  Draw\DrawInterface $draw
     * @return AdapterInterface
     */
    public function setDraw(Draw\DrawInterface $draw);

    /**
     * Set the image effect object
     *
     * @param  Effect\EffectInterface $effect
     * @return AdapterInterface
     */
    public function setEffect(Effect\EffectInterface $effect);

    /**
     * Set the image filter object
     *
     * @param  Filter\FilterInterface $filter
     * @return AdapterInterface
     */
    public function setFilter(Filter\FilterInterface $filter);

    /**
     * Set the image layer object
     *
     * @param  Layer\LayerInterface $layer
     * @return AdapterInterface
     */
    public function setLayer(Layer\LayerInterface $layer);

    /**
     * Set the image type object
     *
     * @param  Type\TypeInterface $type
     * @return AdapterInterface
     */
    public function setType(Type\TypeInterface $type);

    /**
     * Load the image resource from the existing image file
     *
     * @param  string $name
     * @return AdapterInterface
     */
    public function load($name = null);

    /**
     * Load the image resource from data
     *
     * @param  string $data
     * @param  string $name
     * @return AdapterInterface
     */
    public function loadFromString($data, $name = null);

    /**
     * Create a new image resource
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $name
     * @return AdapterInterface
     */
    public function create($width = null, $height = null, $name = null);

    /**
     * Create a new indexed image resource
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $name
     * @return AdapterInterface
     */
    public function createIndex($width = null, $height = null, $name = null);

    /**
     * Resize the image object to the width parameter passed
     *
     * @param  int $w
     * @return AdapterInterface
     */
    public function resizeToWidth($w);

    /**
     * Resize the image object to the height parameter passed
     *
     * @param  int $h
     * @return AdapterInterface
     */
    public function resizeToHeight($h);

    /**
     * Resize the image object, allowing for the largest dimension
     * to be scaled to the value of the $px argument.
     *
     * @param  int $px
     * @return AdapterInterface
     */
    public function resize($px);

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument.
     *
     * @param  float $scale
     * @return AdapterInterface
     */
    public function scale($scale);

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
     * @return AdapterInterface
     */
    public function crop($w, $h, $x = 0, $y = 0);

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $offset argument allows for the
     * adjustment of the crop to select a certain area of the image to be cropped.
     *
     * @param  int $px
     * @param  int $offset
     * @return AdapterInterface
     */
    public function cropThumb($px, $offset = null);

    /**
     * Rotate the image object
     *
     * @param  int                  $degrees
     * @param  Color\ColorInterface $bgColor
     * @throws Exception
     * @return Gd
     */
    public function rotate($degrees, Color\ColorInterface $bgColor = null);

    /**
     * Method to flip the image over the x-axis
     *
     * @return AdapterInterface
     */
    public function flip();

    /**
     * Method to flip the image over the y-axis
     *
     * @return AdapterInterface
     */
    public function flop();

    /**
     * Get the image adjust object
     *
     * @return Adjust\AdjustInterface
     */
    public function adjust();

    /**
     * Get the image filter object
     *
     * @return Filter\FilterInterface
     */
    public function filter();

    /**
     * Get the image layer object
     *
     * @return Layer\LayerInterface
     */
    public function layer();

    /**
     * Get the image draw object
     *
     * @return Draw\DrawInterface
     */
    public function draw();

    /**
     * Get the image effect object
     *
     * @return Effect\EffectInterface
     */
    public function effect();

    /**
     * Get the image type object
     *
     * @return Type\TypeInterface
     */
    public function type();

    /**
     * Convert the image object to another format
     *
     * @param  string $type
     * @throws Exception
     * @return AdapterInterface
     */
    public function convert($type);

    /**
     * Write the image object to a file on disk
     *
     * @param  string $to
     * @param  int    $quality
     * @throws Exception
     * @return void
     */
    public function writeToFile($to = null, $quality = 100);

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
    public function outputToHttp($quality = 100, $to = null, $download = false, $sendHeaders = true);

    /**
     * Destroy the image object and the related image file directly
     *
     * @param  boolean $delete
     * @return void
     */
    public function destroy($delete = false);

    /**
     * Create and return a color.
     *
     * @param  Color\ColorInterface $color
     * @param  int                  $alpha
     * @throws Exception
     * @return mixed
     */
    public function createColor(Color\ColorInterface $color = null, $alpha = 100);

    /**
     * Send image headers the image
     *
     * @param  string  $to
     * @param  boolean $download
     * @return void
     */
    public function sendHeaders($to = null, $download = false);

    /**
     * Output the image
     *
     * @return string
     */
    public function __toString();

}