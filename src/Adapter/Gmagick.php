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
     * Image compression
     * @var int
     */
    protected $compression = null;

    /**
     * Image filter
     * @var int
     */
    protected $imageFilter = \Gmagick::FILTER_LANCZOS;

    /**
     * Image blur
     * @var float
     */
    protected $imageBlur = 1;

    /**
     * Load the image resource from the existing image file
     *
     * @param  string $name
     * @throws Exception
     * @return Gmagick
     */
    public function load($name = null)
    {
        if (null !== $name) {
            $this->name = $name;
        }

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

        $this->format = strtolower($this->resource->getimageformat());
        if ($this->resource->getimagecolors() < 256) {
            $this->indexed = true;
        }

        if ((strpos($this->format, 'jp') !== false) && function_exists('exif_read_data')) {
            $this->exif = exif_read_data($this->name);
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

        $this->format = strtolower($this->resource->getimageformat());
        if ($this->resource->getimagecolors() < 256) {
            $this->indexed = true;
        }

        if ((strpos($this->format, 'jp') !== false) && function_exists('exif_read_data')) {
            $this->exif = exif_read_data($this->name);
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
     * @return Gmagick
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

        $this->resource = new \Gmagick();
        $this->resource->newimage($this->width, $this->height, 'white');

        if (null !== $this->name) {
            $extension = strtolower(substr($this->name, (strrpos($this->name, '.') + 1)));
            if (!empty($extension)) {
                $this->resource->setimageformat($extension);
                $this->format = $extension;
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
     * @return Gmagick
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

        $this->resource = new \Gmagick();
        $this->resource->newimage($this->width, $this->height, new \GmagickPixel('white'));

        if (null !== $this->name) {
            $extension = strtolower(substr($this->name, (strrpos($this->name, '.') + 1)));
            if (!empty($extension)) {
                $this->resource->setimageformat($extension);
                $this->format = $extension;
            }
        }

        $this->resource->setimagetype(\Gmagick::IMGTYPE_PALETTE);

        return $this;
    }

    /**
     * Set the image compression
     *
     * @param  int $compression
     * @return Gmagick
     */
    public function setCompression($compression)
    {
        $this->compression = $compression;
        return $this;
    }

    /**
     * Set the image filter
     *
     * @param  int $filter
     * @return Gmagick
     */
    public function setImageFilter($filter)
    {
        $this->imageFilter = $filter;
        return $this;
    }

    /**
     * Set the image blur
     *
     * @param  float $blur
     * @return Gmagick
     */
    public function setImageBlur($blur)
    {
        $this->imageBlur = $blur;
        return $this;
    }

    /**
     * Get the image compression
     *
     * @return int
     */
    public function getCompression()
    {
        return $this->compression;
    }

    /**
     * Get the image filter
     *
     * @return int
     */
    public function getImageFilter()
    {
        return $this->imageFilter;
    }

    /**
     * Get the image blur
     *
     * @return float
     */
    public function getImageBlur()
    {
        return $this->imageBlur;
    }

    /**
     * Resize the image object to the width parameter passed
     *
     * @param  int $w
     * @return Gmagick
     */
    public function resizeToWidth($w)
    {
        $scale        = $w / $this->width;
        $this->width  = $w;
        $this->height = round($this->height * $scale);

        $this->resource->resizeimage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
        return $this;
    }

    /**
     * Resize the image object to the height parameter passed
     *
     * @param  int $h
     * @return Gmagick
     */
    public function resizeToHeight($h)
    {
        $scale        = $h / $this->height;
        $this->height = $h;
        $this->width  = round($this->width * $scale);

        $this->resource->resizeimage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
        return $this;
    }

    /**
     * Resize the image object, allowing for the largest dimension
     * to be scaled to the value of the $px argument.
     *
     * @param  int $px
     * @return Gmagick
     */
    public function resize($px)
    {
        $scale        = ($this->width > $this->height) ? ($px / $this->width) : ($px / $this->height);
        $this->width  = round($this->width * $scale);
        $this->height = round($this->height * $scale);

        $this->resource->resizeimage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
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
        $this->width  = round($this->width * $scale);
        $this->height = round($this->height * $scale);

        $this->resource->resizeimage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
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
        $this->width  = $w;
        $this->height = $h;
        $this->resource->cropimage($this->width, $this->height, $x, $y);
        return $this;
    }

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $offset argument allows for the
     * adjustment of the crop to select a certain area of the image to be cropped.
     *
     * @param  int $px
     * @param  int $offset
     * @return Gmagick
     */
    public function cropThumb($px, $offset = null)
    {
        $xOffset = 0;
        $yOffset = 0;

        if (null !== $offset) {
            if ($this->width > $this->height) {
                $xOffset = $offset;
                $yOffset = 0;
            } else if ($this->width < $this->height) {
                $xOffset = 0;
                $yOffset = $offset;
            }
        }

        $scale = ($this->width > $this->height) ? ($px / $this->height) : ($px / $this->width);

        $wid = round($this->width * $scale);
        $hgt = round($this->height * $scale);

        // Create a new image output resource.
        if (null !== $offset) {
            $this->resource->resizeimage($wid, $hgt, $this->imageFilter, $this->imageBlur);
            $this->resource->cropimage($px, $px, $xOffset, $yOffset);
        } else {
            $this->resource->cropthumbnailimage($px, $px);
        }

        $this->width  = $px;
        $this->height = $px;
        return $this;
    }

    /**
     * Rotate the image object
     *
     * @param  int                  $degrees
     * @param  Color\ColorInterface $bgColor
     * @throws Exception
     * @return Gmagick
     */
    public function rotate($degrees, Color\ColorInterface $bgColor = null)
    {
        $this->resource->rotateimage($this->createColor($bgColor), $degrees);
        $this->width  = $this->resource->getimagewidth();
        $this->height = $this->resource->getimageheight();
        return $this;
    }

    /**
     * Method to flip the image over the x-axis
     *
     * @return Gmagick
     */
    public function flip()
    {
        $this->resource->flipimage();
        return $this;
    }

    /**
     * Method to flip the image over the y-axis
     *
     * @return Gmagick
     */
    public function flop()
    {
        $this->resource->flopimage();
        return $this;
    }

    /**
     * Convert the image object to another format
     *
     * @param  string $type
     * @return Gmagick
     */
    public function convert($type)
    {
        $type = strtolower($type);
        $old  = strtolower($this->format);

        if ((($old == 'psd') || ($old == 'tif') || ($old == 'tiff')) && method_exists($this->resource, 'flattenImages')) {
            $this->resource->flattenimages();
        }

        $this->resource->setimageformat($type);
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
        if (null !== $this->compression) {
            $this->resource->setimagecompression($this->compression);
        }

        $this->resource->setimagecompressionquality($quality);

        if (null === $to) {
            $to = (null !== $this->name) ? $this->name : 'pop-image.' . $this->format;
        }

        $this->resource->writeimage($to);
    }

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
    public function outputToHttp($quality = 100, $to = null, $download = false, $sendHeaders = true)
    {
        if (null === $this->resource) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if (((int)$quality < 0) || ((int)$quality < 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        if (null !== $this->compression) {
            $this->resource->setimagecompression($this->compression);
        }

        $this->resource->setimagecompressionquality($quality);

        if (null === $to) {
            $to = (null !== $this->name) ? $this->name : 'pop-image.' . strtolower($this->format);
        }

        // Determine if the force download argument has been passed.
        $headers = [
            'Content-type'        => $this->resource->getImageMimeType(),
            'Content-disposition' => (($download) ? 'attachment; ' : null) . 'filename=' . $to
        ];

        if (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] == 443)) {
            $headers['Expires']       = 0;
            $headers['Cache-Control'] = 'private, must-revalidate';
            $headers['Pragma']        = 'cache';
        }

        // Send the headers and output the image
        if (!headers_sent() && ($sendHeaders)) {
            header('HTTP/1.1 200 OK');
            foreach ($headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }

        echo $this->resource;
    }

    /**
     * Destroy the image object and the related image file directly
     *
     * @param  boolean $delete
     * @return void
     */
    public function destroy($delete = false)
    {
        if (null !== $this->resource) {
            $this->resource->clear();
            $this->resource->destroy();
        }

        $this->resource = null;
        clearstatcache();

        // If the $delete flag is passed, delete the image file.
        if (($delete) && file_exists($this->name)) {
            unlink($this->name);
        }
    }

    /**
     * Create and return a color.
     *
     * @param  Color\ColorInterface $color
     * @param  int                  $alpha
     * @throws Exception
     * @return \GmagickPixel
     */
    protected function createColor(Color\ColorInterface $color = null, $alpha = 100)
    {
        if (null === $this->resource) {
            throw new Exception('Error: The image resource has not been created.');
        }

        if ($color instanceof Color\Gray) {
            $color = $color->toRgb();
        }

        if ($color instanceof Color\Cmyk) {
            $pixel = ((int)$alpha < 100) ?
                new \GmagickPixel('cmyka(' . $color . ', ' . (int)$alpha . ')') : new \GmagickPixel('cmyk(' . $color . ')');
        } else {
            $pixel = ((int)$alpha < 100) ?
                new \GmagickPixel('rgba(' . $color . ',' . (int)$alpha . ')') : new \GmagickPixel('rgb(' . $color . ')');
        }

        return $pixel;
    }

}