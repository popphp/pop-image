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
 * Gd adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
 */
class Gd extends AbstractAdapter
{

    /**
     * Load the image resource from the existing image file
     *
     * @throws Exception
     * @return Gd
     */
    public function load()
    {
        if ((null === $this->name) || !file_exists($this->name)) {
            throw new Exception('Error: The image file has not been passed to the image adapter');
        }

        if (stripos($this->name, '.gif') !== false) {
            $this->resource = imagecreatefromgif($this->name);
        } else if (stripos($this->name, '.jp') !== false) {
            $this->resource = imagecreatefromjpeg($this->name);
        } else if (stripos($this->name, '.png') !== false) {
            $this->resource = imagecreatefrompng($this->name);
        } else {
            throw new Exception('Error: The image file must be a GIF, PNG or JPG');
        }

        if ($this->resource === false) {
            throw new Exception('Error: Unable to load image resource');
        }

        $size = getimagesize($this->name);

        $this->width  = $size[0];
        $this->height = $size[1];

        if (isset($size['channels'])) {
            switch ($size['channels']) {
                case 1:
                    $this->colorspace = self::IMAGE_GRAY;
                    break;
                case 3:
                    $this->colorspace = self::IMAGE_RGB;
                    break;
                case 4:
                    $this->colorspace = self::IMAGE_CMYK;
                    break;
            }
        }

        return $this;
    }

    /**
     * Load the image resource from data
     *
     * @param  string $data
     * @param  string $name
     * @throws Exception
     * @return Gd
     */
    public function loadFromString($data, $name = null)
    {
        $this->resource = imagecreatefromstring($data);

        if ($this->resource === false) {
            throw new Exception('Error: Unable to load image resource');
        }

        $this->name = $name;

        $size = getimagesizefromstring($data);

        $this->width  = $size[0];
        $this->height = $size[1];

        if (isset($size['channels'])) {
            switch ($size['channels']) {
                case 1:
                    $this->colorspace = self::IMAGE_GRAY;
                    break;
                case 3:
                    $this->colorspace = self::IMAGE_RGB;
                    break;
                case 4:
                    $this->colorspace = self::IMAGE_CMYK;
                    break;
            }
        }

        return $this;
    }

    /**
     * Create a new image resource
     *
     * @throws Exception
     * @return Gd
     */
    public function create()
    {
        $this->resource = (stripos($this->name, '.gif') !== false) ?
            imagecreate($this->width, $this->height) : imagecreatetruecolor($this->width, $this->height);

        if ($this->resource === false) {
            throw new Exception('Error: Unable to crate image resource');
        }

        return $this;
    }

    /**
     * Resize the image object to the width parameter passed.
     *
     * @param  int $w
     * @return Gd
     */
    public function resizeToWidth($w)
    {
        return $this;
    }

    /**
     * Resize the image object to the height parameter passed.
     *
     * @param  int $h
     * @return Gd
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
     * @return Gd
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
     * @return Gd
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
     * @return Gd
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
     * @return Gd
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
     * @return Gd
     */
    public function rotate($degrees, ColorInterface $bgColor = null)
    {
        return $this;
    }

    /**
     * Method to flip the image over the x-axis.
     *
     * @return Gd
     */
    public function flip()
    {
        return $this;
    }

    /**
     * Method to flip the image over the y-axis.
     *
     * @return Gd
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
     * @return Gd
     */
    public function convert($type)
    {
        return $this;
    }

}