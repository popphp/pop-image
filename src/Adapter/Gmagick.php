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
 * Gmagick adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
 */
class Gmagick extends AbstractAdapter
{

    /**
     * Load the image resource from the existing image file
     *
     * @throws Exception
     * @return Gmagick
     */
    public function load()
    {
        if ((null === $this->name) || !file_exists($this->name)) {
            throw new Exception('Error: The image file has not been passed to the image adapter');
        }

        $this->resource = new \Gmagick($this->name);
        $this->width    = $this->resource->getimagewidth();
        $this->height   = $this->resource->getimageheight();

        switch ($this->resource->getimagecolorspace()) {
            case \Gmagick::COLORSPACE_GRAY:
                $this->colorspace = self::IMAGE_GRAY;
                break;
            case \Gmagick::COLORSPACE_RGB:
            case \Gmagick::COLORSPACE_SRGB:
                $this->colorspace = self::IMAGE_RGB;
                break;
            case \Gmagick::COLORSPACE_CMYK:
                $this->colorspace = self::IMAGE_CMYK;
                break;
        }

        return $this;
    }

    /**
     * Load the image resource from data
     *
     * @param  string $data
     * @param  string $name
     * @throws Exception
     * @return Gmagick
     */
    public function loadFromString($data, $name = null)
    {
        $this->resource = new \Gmagick();
        $this->resource->readimageblob($data);

        $this->name = $name;

        switch ($this->resource->getimagecolorspace()) {
            case \Gmagick::COLORSPACE_GRAY:
                $this->colorspace = self::IMAGE_GRAY;
                break;
            case \Gmagick::COLORSPACE_RGB:
            case \Gmagick::COLORSPACE_SRGB:
                $this->colorspace = self::IMAGE_RGB;
                break;
            case \Gmagick::COLORSPACE_CMYK:
                $this->colorspace = self::IMAGE_CMYK;
                break;
        }

        return $this;
    }

    /**
     * Create a new image resource
     *
     * @throws Exception
     * @return Gmagick
     */
    public function create()
    {
        $this->resource = new \Gmagick();
        $this->resource->newimage($this->width, $this->height, 'white');

        if (null !== $this->name) {
            $extension = strtolower(substr($this->name, (strrpos($this->name, '.') + 1)));
            if (!empty($extension)) {
                $this->resource->setimageformat($extension);
            }
        }

        return $this;
    }

    /**
     * Resize the image object to the width parameter passed.
     *
     * @param  int $w
     * @return Gmagick
     */
    public function resizeToWidth($w)
    {
        return $this;
    }

    /**
     * Resize the image object to the height parameter passed.
     *
     * @param  int $h
     * @return Gmagick
     */
    public function resizeToHeight($h)
    {
        return $this;
    }

    /**
     * Resize the image object, allowing for the largest dimension to be scaled
     * to the value of the $px argument.
     *
     * @param  int $px
     * @return Gmagick
     */
    public function resize($px)
    {
        return $this;
    }

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument.
     *
     * @param  float $scale
     * @return Gmagick
     */
    public function scale($scale)
    {
        return $this;
    }

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
     * @return Gmagick
     */
    public function crop($w, $h, $x = 0, $y = 0)
    {
        return $this;
    }

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $offset argument allows for the
     * adjustment of the crop to select a certain area of the image to be
     * cropped.
     *
     * @param  int $px
     * @param  int $offset
     * @return Gmagick
     */
    public function cropThumb($px, $offset = null)
    {
        return $this;
    }

    /**
     * Rotate the image object
     *
     * @param  int            $degrees
     * @param  ColorInterface $bgColor
     * @throws Exception
     * @return Gmagick
     */
    public function rotate($degrees, ColorInterface $bgColor = null)
    {
        return $this;
    }

    /**
     * Method to flip the image over the x-axis.
     *
     * @return Gmagick
     */
    public function flip()
    {
        return $this;
    }

    /**
     * Method to flip the image over the y-axis.
     *
     * @return Gmagick
     */
    public function flop()
    {
        return $this;
    }

    /**
     * Convert the image object to another format.
     *
     * @param  string $type
     * @throws Exception
     * @return Gmagick
     */
    public function convert($type)
    {
        return $this;
    }

}