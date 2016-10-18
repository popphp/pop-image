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

use Pop\Image\Color;

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
     * @param  string $name
     * @throws Exception
     * @return Gd
     */
    public function load($name = null)
    {
        if (null !== $name) {
            $this->name = $name;
        }

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

        $this->parseImage(getimagesize($this->name), file_get_contents($this->name));
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

        $this->parseImage(getimagesizefromstring($data), $data);
        return $this;
    }

    /**
     * Create a new image resource
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $name
     * @throws Exception
     * @return Gd
     */
    public function create($width = null, $height = null, $name = null)
    {
        if ((null !== $width) && (null !== $height)) {
            $this->width  = $width;
            $this->height = $height;
        }

        if (null !== $name) {
            $this->name = $name;
        }

        if ((null === $this->width) && (null === $this->height)) {
            throw new Exception('Error: You must pass a width and a height');
        }

        if (stripos($this->name, '.gif') !== false) {
            $this->resource = imagecreate($this->width, $this->height);
            $this->indexed  = true;
        } else {
            $this->resource = imagecreatetruecolor($this->width, $this->height);
        }

        if ($this->resource === false) {
            throw new Exception('Error: Unable to create image resource');
        }

        return $this;
    }

    /**
     * Create a new image resource
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $name
     * @throws Exception
     * @return Gd
     */
    public function createIndex($width = null, $height = null, $name = null)
    {
        if ((null !== $width) && (null !== $height)) {
            $this->width  = $width;
            $this->height = $height;
        }

        if (null !== $name) {
            $this->name = $name;
        }

        if ((null === $this->width) && (null === $this->height)) {
            throw new Exception('Error: You must pass a width and a height');
        }

        $this->resource = imagecreate($this->width, $this->height);
        $this->indexed  = true;

        if ($this->resource === false) {
            throw new Exception('Error: Unable to create image resource');
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
        $scale = $w / $this->width;
        $h     = round($this->height * $scale);
        $this->copyImage($w, $h);

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
        $scale = $h / $this->height;
        $w     = round($this->width * $scale);
        $this->copyImage($w, $h);

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
        $scale = ($this->width > $this->height) ? ($px / $this->width) : ($px / $this->height);
        $w     = round($this->width * $scale);
        $h     = round($this->height * $scale);
        $this->copyImage($w, $h);

        return $this;
    }

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scale argument.
     *
     * @param  float $scale
     * @return Gd
     */
    public function scale($scale)
    {
        $w = round($this->width * $scale);
        $h = round($this->height * $scale);
        $this->copyImage($w, $h);

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
        $this->copyImage($w, $h, $x, $y);
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
        $xOffset = 0;
        $yOffset = 0;
        $scale   = ($this->width > $this->height) ? ($px / $this->height) : ($px / $this->width);
        $w       = round($this->width * $scale);
        $h       = round($this->height * $scale);

        if (null !== $offset) {
            if ($this->width > $this->height) {
                $xOffset = $offset;
                $yOffset = 0;
            } else if ($this->width < $this->height) {
                $xOffset = 0;
                $yOffset = $offset;
            }
        } else {
            if ($this->width > $this->height) {
                $xOffset = round(($this->width - $this->height) / 2);
                $yOffset = 0;
            } else if ($this->width < $this->height) {
                $xOffset = 0;
                $yOffset = round(($this->height - $this->width) / 2);
            }
        }

        $result = imagecreatetruecolor($px, $px);
        imagecopyresampled($result, $this->resource, 0, 0, $xOffset, $yOffset, $w, $h, $this->width, $this->height);

        if ($this->indexed) {
            imagetruecolortopalette($result, false, 255);
        }

        $this->resource = $result;
        $this->width    = imagesx($this->resource);
        $this->height   = imagesy($this->resource);

        return $this;
    }

    /**
     * Rotate the image object
     *
     * @param  int                  $degrees
     * @param  Color\ColorInterface $bgColor
     * @param  int                  $alpha
     * @return Gd
     */
    public function rotate($degrees, Color\ColorInterface $bgColor = null, $alpha = null)
    {
        $this->resource = imagerotate($this->resource, $degrees, $this->createColor($bgColor, $alpha));
        $this->width    = imagesx($this->resource);
        $this->height   = imagesy($this->resource);
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

    /**
     * Copy the image resource to the image output resource with the set parameters.
     *
     * @param  int $w
     * @param  int $h
     * @param  int $x
     * @param  int $y
     * @return void
     */
    protected function copyImage($w, $h, $x = 0, $y = 0)
    {
        $result = imagecreatetruecolor($w, $h);
        imagecopyresampled($result, $this->resource, 0, 0, $x, $y, $w, $h, $this->width, $this->height);

        if ($this->indexed) {
            imagetruecolortopalette($result, false, 255);
        }

        $this->resource = $result;
        $this->width    = imagesx($this->resource);
        $this->height   = imagesy($this->resource);
    }

    /**
     * Parse the image data
     *
     * @param  array  $size
     * @param  string $data
     * @return void
     */
    protected function parseImage(array $size, $data)
    {
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
        } else if ($size[2] == IMAGETYPE_PNG) {
            switch (ord($data[25])) {
                case 0:
                    $this->colorspace = self::IMAGE_GRAY;
                    break;
                case 2:
                    $this->colorspace = self::IMAGE_RGB;
                    break;
                case 3:
                    $this->colorspace = self::IMAGE_RGB;
                    $this->indexed    = true;
                    break;
                case 4:
                    $this->colorspace = self::IMAGE_GRAY;
                    break;
                case 6:
                    $this->colorspace = self::IMAGE_RGB;
                    break;
            }
        } else if ($size[2] == IMAGETYPE_GIF) {
            $this->colorspace = self::IMAGE_RGB;
            $this->indexed    = true;
        }
    }

    /**
     * Create and return a color.
     *
     * @param  Color\ColorInterface $color
     * @param  int                  $alpha
     * @throws Exception
     * @return mixed
     */
    public function createColor(Color\ColorInterface $color = null, $alpha = null)
    {
        if (null === $color) {
            $color = new Color\Rgb(0, 0, 0);
        }

        if (!($color instanceof Color\Rgb)) {
            $color = $color->toRgb();
        }

        $r = $color->getR();
        $g = $color->getG();
        $b = $color->getB();

        if (null !== $alpha) {
            if (((int)$alpha < 0) || ((int)$alpha > 127)) {
                throw new \OutOfRangeException('Error: The alpha parameter must be between 0 and 127');
            }
            return imagecolorallocatealpha($this->resource, (int)$r, (int)$g, (int)$b, (int)$alpha);
        } else {
            return imagecolorallocate($this->resource, (int)$r, (int)$g, (int)$b);
        }
    }

}