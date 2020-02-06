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
 * Imagick adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
class Imagick extends AbstractAdapter
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
    protected $imageFilter = \Imagick::FILTER_LANCZOS;

    /**
     * Image blur
     * @var float
     */
    protected $imageBlur = 1;

    /**
     * Create the image resource
     *
     * @return void
     */
    public function createResource()
    {
        $this->resource = new \Imagick();
    }

    /**
     * Load the image resource from the existing image file
     *
     * @param  string $name
     * @throws Exception
     * @return Imagick
     */
    public function load($name = null)
    {
        $filename = null;
        if (null !== $name) {
            $filename = ((strpos($name, '[') !== false) && (strpos($name, ']') !== false)) ?
                substr($name, 0, strpos($name, '[')) : $name;
            $this->name = $name;
        }

        if ((null === $this->name) || ((null !== $filename) && !file_exists($filename))) {
            throw new Exception('Error: The image file has not been passed to the image adapter');
        }

        if (null !== $this->resource) {
            $this->resource->readImage($this->name);
        } else {
            $this->resource = new \Imagick($this->name);
        }

        $this->width  = $this->resource->getImageWidth();
        $this->height = $this->resource->getImageHeight();

        switch ($this->resource->getImageColorspace()) {
            case \Imagick::COLORSPACE_GRAY:
                $this->colorspace = self::IMAGE_GRAY;
                break;
            case \Imagick::COLORSPACE_RGB:
            case \Imagick::COLORSPACE_SRGB:
                $this->colorspace = self::IMAGE_RGB;
                break;
            case \Imagick::COLORSPACE_CMYK:
                $this->colorspace = self::IMAGE_CMYK;
                break;
        }

        $this->format = strtolower($this->resource->getImageFormat());
        if ($this->resource->getImageColors() < 256) {
            $this->indexed = true;
        }

        if ((strpos($this->format, 'jp') !== false) && function_exists('exif_read_data')) {
            $exif = @exif_read_data($this->name);
            if ($exif !== false) {
                $this->exif = $exif;
            }
        }

        return $this;
    }

    /**
     * Load the image resource from data
     *
     * @param  string $data
     * @param  string $name
     * @return Imagick
     */
    public function loadFromString($data, $name = null)
    {
        if (null === $this->resource) {
            $this->resource = new \Imagick();
        }
        $this->resource->readImageBlob($data);

        $this->name = $name;

        switch ($this->resource->getImageColorspace()) {
            case \Imagick::COLORSPACE_GRAY:
                $this->colorspace = self::IMAGE_GRAY;
                break;
            case \Imagick::COLORSPACE_RGB:
            case \Imagick::COLORSPACE_SRGB:
                $this->colorspace = self::IMAGE_RGB;
                break;
            case \Imagick::COLORSPACE_CMYK:
                $this->colorspace = self::IMAGE_CMYK;
                break;
        }

        $this->format = strtolower($this->resource->getImageFormat());
        if ($this->resource->getImageColors() < 256) {
            $this->indexed = true;
        }

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
     * @return Imagick
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

        if (null === $this->resource) {
            $this->resource = new \Imagick();
        }

        $this->resource->newImage($this->width, $this->height, new \ImagickPixel('white'));

        if (null !== $this->name) {
            $extension = strtolower(substr($this->name, (strrpos($this->name, '.') + 1)));
            if (!empty($extension)) {
                $this->resource->setImageFormat($extension);
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
     * @return Imagick
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

        if (null === $this->resource) {
            $this->resource = new \Imagick();
        }

        $this->resource->newImage($this->width, $this->height, new \ImagickPixel('white'));

        if (null !== $this->name) {
            $extension = strtolower(substr($this->name, (strrpos($this->name, '.') + 1)));
            if (!empty($extension)) {
                $this->resource->setImageFormat($extension);
                $this->format = $extension;
            }
        }

        $this->resource->setImageType(\Imagick::IMGTYPE_PALETTE);
        $this->indexed = true;

        return $this;
    }

    /**
     * Add image to the image resource
     *
     * @param  mixed $image
     * @param  int   $delay
     * @return Imagick
     */
    public function addImage($image, $delay = null)
    {
        if (!($image instanceof \Imagick)) {
            $image = new \Imagick($image);
        }
        if (null !== $delay) {
            $image->setImageDelay($delay);
        }
        $this->resource->addImage($image);
        return $this;
    }

    /**
     * Does image have images
     *
     * @return boolean
     */
    public function hasImages()
    {
        return ($this->resource->getNumberImages() > 0);
    }

    /**
     * Get images
     *
     * @return array
     */
    public function getImages()
    {
        return $this->resource->coalesceImages();
    }

    /**
     * Get images
     *
     * @param  \Imagick $images
     * @return Imagick
     */
    public function rebuildImages(\Imagick $images)
    {
        $this->resource = $images->deconstructImages();
        return $this;
    }

    /**
     * Set the image resolution
     *
     * @param  int $x
     * @param  int $y
     * @return Imagick
     */
    public function setResolution($x, $y = null)
    {
        if (null === $y) {
            $y = $x;
        }
        $this->resource->setResolution($x, $y);
        return $this;
    }

    /**
     * Set the image colorspace
     *
     * @param  int $colorspace
     * @return Imagick
     */
    public function setImageColorspace($colorspace)
    {
        $this->resource->setImageColorspace($colorspace);
        return $this;
    }

    /**
     * Set the image compression
     *
     * @param  int $compression
     * @return Imagick
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
     * @return Imagick
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
     * @return Imagick
     */
    public function setImageBlur($blur)
    {
        $this->imageBlur = $blur;
        return $this;
    }

    /**
     * Get number of images
     *
     * @return int
     */
    public function getNumberOfImages()
    {
        return $this->resource->getNumberImages();
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
     * @return Imagick
     */
    public function resizeToWidth($w)
    {
        $scale        = $w / $this->width;
        $this->width  = $w;
        $this->height = round($this->height * $scale);

        return $this->resizeImage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
    }

    /**
     * Resize the image object to the height parameter passed
     *
     * @param  int $h
     * @return Imagick
     */
    public function resizeToHeight($h)
    {
        $scale        = $h / $this->height;
        $this->height = $h;
        $this->width  = round($this->width * $scale);

        return $this->resizeImage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
    }

    /**
     * Resize the image object, allowing for the largest dimension
     * to be scaled to the value of the $px argument.
     *
     * @param  int $px
     * @return Imagick
     */
    public function resize($px)
    {
        $scale        = ($this->width > $this->height) ? ($px / $this->width) : ($px / $this->height);
        $this->width  = round($this->width * $scale);
        $this->height = round($this->height * $scale);

        return $this->resizeImage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
    }

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument.
     *
     * @param  float $scale
     * @return Imagick
     */
    public function scale($scale)
    {
        $this->width  = round($this->width * $scale);
        $this->height = round($this->height * $scale);

        return $this->resizeImage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
    }

    /**
     * Resize image, checking for multiple frames
     *
     * @param  int $width
     * @param  int $height
     * @param  int $filter
     * @param  int $blur
     * @return Imagick
     */
    public function resizeImage($width, $height, $filter = null, $blur = null)
    {
        if (null === $filter) {
            $filter = $this->imageFilter;
        }
        if (null === $blur) {
            $blur = $this->imageBlur;
        }
        if ($this->resource->getNumberImages() > 0) {
            $frames = $this->resource->coalesceImages();
            foreach ($frames as $frame) {
                $frame->resizeImage($width, $height, $filter, $blur);
            }
            $this->resource = $frames->deconstructImages();
        } else {
            $this->resource->resizeImage($width, $height, $filter, $blur);
        }

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
     * @return Imagick
     */
    public function crop($w, $h, $x = 0, $y = 0)
    {
        $this->width  = $w;
        $this->height = $h;
        return $this->cropImage($this->width, $this->height, $x, $y);
    }

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $offset argument allows for the
     * adjustment of the crop to select a certain area of the image to be cropped.
     *
     * @param  int $px
     * @param  int $offset
     * @return Imagick
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
            $this->resizeImage($wid, $hgt, $this->imageFilter, $this->imageBlur);
            $this->cropImage($px, $px, $xOffset, $yOffset);
        } else {
            $this->cropThumbnailImage($px, $px);
        }

        $this->width  = $px;
        $this->height = $px;
        return $this;
    }

    /**
     * Crop image, checking for multiple frames
     *
     * @param  int $width
     * @param  int $height
     * @param  int $x
     * @param  int $y
     * @return Imagick
     */
    public function cropImage($width, $height, $x, $y)
    {
        if ($this->resource->getNumberImages() > 0) {
            $frames = $this->resource->coalesceImages();
            foreach ($frames as $frame) {
                $frame->setImageBackgroundColor('none');
                $frame->cropImage($width, $height, $x, $y);
                $frame->thumbnailImage($width, $height);
                $frame->setImagePage($width, $height, 0, 0);
            }
            $this->resource = $frames->deconstructImages();
            $this->resource->resizeImage($width, $height, $this->imageFilter, $this->imageBlur);
        } else {
            $this->resource->cropImage($width, $height, $x, $y);
        }

        return $this;
    }

    /**
     * Crop image, checking for multiple frames
     *
     * @param  int $width
     * @param  int $height
     * @return Imagick
     */
    public function cropThumbnailImage($width, $height)
    {
        if ($this->resource->getNumberImages() > 0) {
            $frames = $this->resource->coalesceImages();
            foreach ($frames as $frame) {
                $frame->setImageBackgroundColor('none');
                $frame->cropThumbnailImage($width, $height);
                $frame->thumbnailImage($width, $height);
                $frame->setImagePage($width, $height, 0, 0);
            }
            $this->resource = $frames->deconstructImages();
        } else {
            $this->resource->cropThumbnailImage($width, $height);
        }

        return $this;
    }

    /**
     * Rotate the image object
     *
     * @param  int                  $degrees
     * @param  Color\ColorInterface $bgColor
     * @return Imagick
     */
    public function rotate($degrees, Color\ColorInterface $bgColor = null)
    {
        $this->resource->rotateImage($this->createColor($bgColor), $degrees);
        $this->width  = $this->resource->getImageWidth();
        $this->height = $this->resource->getImageHeight();
        return $this;
    }

    /**
     * Method to flip the image over the x-axis
     *
     * @return Imagick
     */
    public function flip()
    {
        $this->resource->flipImage();
        return $this;
    }

    /**
     * Method to flip the image over the y-axis
     *
     * @return Imagick
     */
    public function flop()
    {
        $this->resource->flopImage();
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
            $this->adjust = new Adjust\Imagick($this);
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
            $this->draw = new Draw\Imagick($this);
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
            $this->effect = new Effect\Imagick($this);
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
            $this->filter = new Filter\Imagick($this);
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
            $this->layer = new Layer\Imagick($this);
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
            $this->type = new Type\Imagick($this);
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
     * @return Imagick
     */
    public function convert($to)
    {
        $to   = strtolower($to);
        $old  = strtolower($this->format);

        if (($old == 'psd') || ($old == 'tif') || ($old == 'tiff')) {
            $this->resource->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
        }

        $this->resource->setImageFormat($to);

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
            default:
                $this->format = $to;
        }

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
        if ((null === $this->resource) || ((null !== $this->resource) && ($this->resource->count() == 0))) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if (null !== $this->compression) {
            $this->resource->setImageCompression($this->compression);
        }

        if (((int)$quality < 0) || ((int)$quality > 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        $this->resource->setImageCompressionQuality($quality);

        if (null === $to) {
            $to = (null !== $this->name) ? basename($this->name) : 'pop-image.' . $this->format;
        } else {
            $this->name = $to;
        }

        $this->resource->writeImage($to);
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
        if ((null === $this->resource) || ((null !== $this->resource) && ($this->resource->count() == 0))) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if (((int)$quality < 0) || ((int)$quality > 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        if (null !== $this->compression) {
            $this->resource->setImageCompression($this->compression);
        }

        $this->resource->setImageCompressionQuality($quality);

        if (null === $to) {
            $to = (null !== $this->name) ? basename($this->name) : 'pop-image.' . strtolower($this->format);
        }

        $this->sendHeaders($to, $download, $headers);
        echo ($this->resource->getNumberImages() > 0) ? $this->resource->getImagesBlob() : $this->resource;
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
     * @return \ImagickPixel
     */
    public function createColor(Color\ColorInterface $color = null, $alpha = 100)
    {
        if (null === $color) {
            $color = new Color\Rgb(0, 0, 0);
        }

        if (!($color instanceof Color\Rgb)) {
            $color = $color->toRgb();
        }

        return ((int)$alpha < 100) ?
            new \ImagickPixel('rgba(' . $color . ',' . (int)$alpha . ')') : new \ImagickPixel('rgb(' . $color . ')');
    }

    /**
     * Output the image
     *
     * @return string
     */
    public function __toString()
    {
        $this->sendHeaders();
        echo ($this->resource->getNumberImages() > 0) ? $this->resource->getImagesBlob() : $this->resource;
        return '';
    }

}