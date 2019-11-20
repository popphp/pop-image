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
 * Gd adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
class Gd extends AbstractAdapter
{

    /**
     * Create the image resource
     *
     * @return void
     */
    public function createResource()
    {
        $this->resource = null;
    }

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
            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data($this->name);
                if ($exif !== false) {
                    $this->exif = $exif;
                }
            }
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
        $this->resource = @imagecreatefromstring($data);

        if ($this->resource === false) {
            throw new Exception('Error: Unable to load image resource');
        }

        $this->parseImage(getimagesizefromstring($data), $data);

        if ((strpos($this->format, 'jp') !== false) && function_exists('exif_read_data')) {
            $exif = @exif_read_data('data://image/jpeg;base64,' . base64_encode($data));
            if ($exif !== false) {
                $this->exif = $exif;
            }
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
            $this->format   = 'gif';
        } else {
            $this->resource = imagecreatetruecolor($this->width, $this->height);
            if (stripos($this->name, '.png') !== false) {
                $this->format = 'png';
            } else if (stripos($this->name, '.jp') !== false) {
                $this->format = 'jpg';
            }
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

        if (stripos($this->name, '.png') !== false) {
            $this->format = 'png';
        } else {
            $this->format = 'gif';
        }

        if ($this->resource === false) {
            throw new Exception('Error: Unable to create image resource');
        }

        return $this;
    }

    /**
     * Resize the image object to the width parameter passed
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
     * Resize the image object to the height parameter passed
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
     * Resize the image object, allowing for the largest dimension
     * to be scaled to the value of the $px argument.
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
        $result = imagecreatetruecolor($w, $h);
        imagecopyresampled(
            $result, $this->resource, 0, 0, $x, $y, $this->width, $this->height, $this->width, $this->height
        );

        if ($this->indexed) {
            imagetruecolortopalette($result, false, 255);
        }

        $this->resource = $result;
        $this->width    = imagesx($this->resource);
        $this->height   = imagesy($this->resource);

        return $this;
    }

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $offset argument allows for the
     * adjustment of the crop to select a certain area of the image to be cropped.
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
     * Method to flip the image over the x-axis
     *
     * @return Gd
     */
    public function flip()
    {
        $curWidth     = $this->width;
        $curHeight    = $this->height;
        $srcX         = 0;
        $srcY         = $this->height - 1; // Compensate for a 1-pixel space on the flipped image
        $this->height = 0 - $this->height;

        $this->copyImage($curWidth, $curHeight, $srcX , $srcY);
        $this->height = abs($this->height);

        return $this;
    }

    /**
     * Method to flip the image over the y-axis
     *
     * @return Gd
     */
    public function flop()
    {
        $curWidth    = $this->width;
        $curHeight   = $this->height;
        $srcX        = $this->width - 1; // Compensate for a 1-pixel space on the flipped image
        $srcY        = 0;
        $this->width = 0 - $this->width;

        $this->copyImage($curWidth, $curHeight, $srcX , $srcY);
        $this->width = abs($this->width);

        return $this;
    }

    /**
     * Get the image adjust object
     *
     * @return Adjust\AdjustInterface
     */
    public function adjust()
    {
        if (null === $this->adjust) {
            $this->adjust = new Adjust\Gd($this);
        }
        if (null === $this->adjust->getImage()) {
            $this->adjust->setImage($this);
        }

        return $this->adjust;
    }

    /**
     * Get the image draw object
     *
     * @return Draw\DrawInterface
     */
    public function draw()
    {
        if (null === $this->draw) {
            $this->draw = new Draw\Gd($this);
        }
        if (null === $this->draw->getImage()) {
            $this->draw->setImage($this);
        }
        return $this->draw;
    }

    /**
     * Get the image effect object
     *
     * @return Effect\EffectInterface
     */
    public function effect()
    {
        if (null === $this->effect) {
            $this->effect = new Effect\Gd($this);
        }
        if (null === $this->effect->getImage()) {
            $this->effect->setImage($this);
        }
        return $this->effect;
    }

    /**
     * Get the image filter object
     *
     * @return Filter\FilterInterface
     */
    public function filter()
    {
        if (null === $this->filter) {
            $this->filter = new Filter\Gd($this);
        }
        if (null === $this->filter->getImage()) {
            $this->filter->setImage($this);
        }
        return $this->filter;
    }

    /**
     * Get the image layer object
     *
     * @return Layer\LayerInterface
     */
    public function layer()
    {
        if (null === $this->layer) {
            $this->layer = new Layer\Gd($this);
        }
        if (null === $this->layer->getImage()) {
            $this->layer->setImage($this);
        }
        return $this->layer;
    }

    /**
     * Get the image type object
     *
     * @return Type\TypeInterface
     */
    public function type()
    {
        if (null === $this->type) {
            $this->type = new Type\Gd($this);
        }
        if (null === $this->type->getImage()) {
            $this->type->setImage($this);
        }
        return $this->type;
    }

    /**
     * Convert the image object to another format
     *
     * @param  string $to
     * @throws Exception
     * @return Gd
     */
    public function convert($to)
    {
        $to = strtolower($to);

        if (($to != 'jpg') && ($to != 'jpeg') && ($to != 'gif') && ($to != 'png')) {
            throw new Exception('Error: The image type must be a GIF, PNG or JPG');
        }

        if (null === $this->resource) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        switch ($to) {
            case 'jpg':
            case 'jpeg':
                $this->format  = 'jpg';
                $this->indexed = false;
                break;
            case 'png':
                $this->format = 'png';
                break;
            case 'gif':
                $this->format  = 'gif';
                $this->indexed = true;
                break;
        }

        if ((null !== $this->name) && (strpos($this->name, '.') !== false)) {
            $this->name = substr($this->name, 0, (strrpos($this->name, '.') + 1)) . $this->format;
        }

        $result = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled(
            $result, $this->resource, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height
        );

        if ($this->indexed) {
            imagetruecolortopalette($result, false, 255);
        }

        $this->resource = $result;
        $this->width    = imagesx($this->resource);
        $this->height   = imagesy($this->resource);

        return $this;
    }

    /**
     * Write the image object to a file on disk
     *
     * @param  string $to
     * @param  int    $quality
     * @throws Exception
     * @return void
     */
    public function writeToFile($to = null, $quality = 100)
    {
        if (null === $this->resource) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if (((int)$quality < 0) || ((int)$quality > 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        $this->format = strtolower($this->format);

        if (null === $to) {
            $to = (null !== $this->name) ? basename($this->name) : 'pop-image.' . $this->format;
        } else {
            $this->name = $to;
        }

        $this->generateImage((int)$quality, $to);
    }

    /**
     * Output the image object directly to HTTP
     *
     * @param  int     $quality
     * @param  string  $to
     * @param  boolean $download
     * @param  boolean $sendHeaders
     * @param  array   $headers
     * @throws Exception
     * @return void
     */
    public function outputToHttp($quality = 100, $to = null, $download = false, $sendHeaders = true, array $headers = [])
    {
        if (null === $this->resource) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if (((int)$quality < 0) || ((int)$quality > 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        $this->format = strtolower($this->format);

        if (null === $to) {
            $to = (null !== $this->name) ? basename($this->name) : 'pop-image.' . $this->format;
        }

        $this->sendHeaders($to, $download, $headers);
        $this->generateImage((int)$quality);
    }

    /**
     * Destroy the image object and the related image file directly
     *
     * @param  boolean $delete
     * @return void
     */
    public function destroy($delete = false)
    {
        // Destroy the image resource.
        if (null !== $this->resource) {
            if (!is_string($this->resource) && is_resource($this->resource)) {
                imagedestroy($this->resource);
            }
        }

        $this->resource = null;
        clearstatcache();

        // If the $delete flag is passed, delete the image file.
        if (($delete) && file_exists($this->name)) {
            unlink($this->name);
        }
    }

    /**
     * Create and return a color
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

    /**
     * Output the image
     *
     * @return string
     */
    public function __toString()
    {
        $this->sendHeaders();
        $this->generateImage(100);
        return '';
    }

    /**
     * Copy the image resource to the image output resource with the set parameters
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

        if ((($size[2] == IMAGETYPE_JPEG) || ($size[2] == IMAGETYPE_JPEG2000)) && isset($size['channels'])) {
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
            $this->format = 'jpg';
        } else if ($size[2] == IMAGETYPE_PNG) {
            switch (ord($data[25])) {
                case 0:
                case 4:
                    $this->colorspace = self::IMAGE_GRAY;
                    break;
                case 2:
                case 6:
                    $this->colorspace = self::IMAGE_RGB;
                    break;
                case 3:
                    $this->colorspace = self::IMAGE_RGB;
                    $this->indexed    = true;
                    break;
            }
            $this->format = 'png';
        } else if ($size[2] == IMAGETYPE_GIF) {
            $this->colorspace = self::IMAGE_RGB;
            $this->indexed    = true;
            $this->format     = 'gif';
        }
    }

    /**
     * Parse the image data
     *
     * @param  int    $quality
     * @param  string $to
     * @return void
     */
    protected function generateImage($quality, $to = null)
    {
        switch ($this->format) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($this->resource, $to, (int)$quality);
                break;
            case 'png':
                $quality = ($quality < 10) ? 9 : 10 - round(($quality / 10), PHP_ROUND_HALF_DOWN);
                imagepng($this->resource, $to, (int)$quality);
                break;
            case 'gif':
                imagegif($this->resource, $to);
                break;
        }
    }

}