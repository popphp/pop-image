<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Adapter;

use Pop\Image\Adjust;
use Pop\Color\Color;
use Pop\Image\Draw;
use Pop\Image\Effect;
use Pop\Image\Filter;
use Pop\Image\Layer;
use Pop\Image\Type;
use ImagickPixel;
use ImagickPixelException;
use ImagickException;

/**
 * Imagick adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    4.0.0
 */
class Imagick extends AbstractAdapter
{

    /**
     * Image compression
     * @var ?int
     */
    protected ?int $compression = null;

    /**
     * Image filter
     * @var int
     */
    protected int $imageFilter = \Imagick::FILTER_LANCZOS;

    /**
     * Image blur
     * @var float
     */
    protected float $imageBlur = 1;

    /**
     * Create the image resource
     *
     * @return void
     */
    public function createResource(): void
    {
        $this->resource = new \Imagick();
    }

    /**
     * Load the image resource from the existing image file
     *
     * @param  ?string $name
     * @throws Exception|ImagickException
     * @return Imagick
     */
    public function load(?string $name = null): Imagick
    {
        $filename = null;
        if ($name !== null) {
            $filename = ((str_contains($name, '[')) && (str_contains($name, ']'))) ?
                substr($name, 0, strpos($name, '[')) : $name;
            $this->name = $name;
        }

        if (($this->name === null) || (($filename !== null) && !file_exists($filename))) {
            throw new Exception('Error: The image file has not been passed to the image adapter');
        }

        if ($this->resource !== null) {
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

        if ((str_contains($this->format, 'jp')) && function_exists('exif_read_data')) {
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
     * @param  string  $data
     * @param  ?string $name
     * @throws ImagickException
     * @return Imagick
     */
    public function loadFromString(string $data, ?string $name = null): Imagick
    {
        if ($this->resource === null) {
            $this->resource = new \Imagick();
        }
        $this->resource->readImageBlob($data);

        if ($name !== null) {
            $this->name = $name;
        }

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

        if ((str_contains($this->format, 'jp')) && function_exists('exif_read_data')) {
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
     * @param  ?int    $width
     * @param  ?int    $height
     * @param  ?string $name
     * @return Imagick
     */
    public function create(?int $width = null, ?int $height = null, ?string $name = null): Imagick
    {
        if (($width !== null) && ($height !== null)) {
            $this->width  = $width;
            $this->height = $height;
        }

        if ($name !== null) {
            $this->name = $name;
        }

        if ($this->resource === null) {
            $this->resource = new \Imagick();
        }

        $this->resource->newImage($this->width, $this->height, new ImagickPixel('white'));

        if ($this->name !== null) {
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
     * @param  ?int    $width
     * @param  ?int    $height
     * @param  ?string $name
     * @throws ImagickException
     * @return Imagick
     */
    public function createIndex(?int $width = null, ?int $height = null, ?string $name = null): Imagick
    {
        if (($width !== null) && ($height !== null)) {
            $this->width  = $width;
            $this->height = $height;
        }

        if ($name !== null) {
            $this->name = $name;
        }

        if ($this->resource === null) {
            $this->resource = new \Imagick();
        }

        $this->resource->newImage($this->width, $this->height, new ImagickPixel('white'));

        if ($this->name !== null) {
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
     * @param  ?int  $delay
     * @throws ImagickException
     * @return Imagick
     */
    public function addImage(mixed $image, ?int $delay = null): Imagick
    {
        if (!($image instanceof \Imagick)) {
            $image = new \Imagick($image);
        }
        if ($delay !== null) {
            $image->setImageDelay($delay);
        }
        $this->resource->addImage($image);
        return $this;
    }

    /**
     * Does image have images
     *
     * @return bool
     */
    public function hasImages(): bool
    {
        return ($this->resource->getNumberImages() > 0);
    }

    /**
     * Get images
     *
     * @return \Imagick
     */
    public function getImages(): \Imagick
    {
        return $this->resource->coalesceImages();
    }

    /**
     * Get images
     *
     * @param  \Imagick $images
     * @throws ImagickException
     * @return Imagick
     */
    public function rebuildImages(\Imagick $images): Imagick
    {
        $this->resource = $images->deconstructImages();
        return $this;
    }

    /**
     * Set the image resolution
     *
     * @param  int  $x
     * @param  ?int $y
     * @return Imagick
     */
    public function setResolution(int $x, ?int $y = null): Imagick
    {
        if ($y === null) {
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
    public function setImageColorspace(int $colorspace): Imagick
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
    public function setCompression(int $compression): Imagick
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
    public function setImageFilter(int $filter): Imagick
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
    public function setImageBlur(float $blur): Imagick
    {
        $this->imageBlur = $blur;
        return $this;
    }

    /**
     * Get number of images
     *
     * @return int
     */
    public function getNumberOfImages(): int
    {
        return $this->resource->getNumberImages();
    }

    /**
     * Get the image compression
     *
     * @return int
     */
    public function getCompression(): int
    {
        return $this->compression;
    }

    /**
     * Get the image filter
     *
     * @return int
     */
    public function getImageFilter(): int
    {
        return $this->imageFilter;
    }

    /**
     * Get the image blur
     *
     * @return float
     */
    public function getImageBlur(): float
    {
        return $this->imageBlur;
    }

    /**
     * Resize the image object to the width parameter passed
     *
     * @param  int $w
     * @return Imagick
     */
    public function resizeToWidth(int $w): Imagick
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
    public function resizeToHeight(int $h): Imagick
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
    public function resize(int $px): Imagick
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
    public function scale(float $scale): Imagick
    {
        $this->width  = round($this->width * $scale);
        $this->height = round($this->height * $scale);

        return $this->resizeImage($this->width, $this->height, $this->imageFilter, $this->imageBlur);
    }

    /**
     * Resize image, checking for multiple frames
     *
     * @param  int  $width
     * @param  int  $height
     * @param  ?int $filter
     * @param  ?int $blur
     * @return Imagick
     */
    public function resizeImage(int $width, int $height, ?int $filter = null, ?int $blur = null): Imagick
    {
        if ($filter === null) {
            $filter = $this->imageFilter;
        }
        if ($blur === null) {
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
    public function crop(int $w, int $h, int $x = 0, int $y = 0): Imagick
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
     * @param  int  $px
     * @param  ?int $offset
     * @return Imagick
     */
    public function cropThumb(int $px, ?int $offset = null): Imagick
    {
        $xOffset = 0;
        $yOffset = 0;

        if ($offset !== null) {
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
        if ($offset !== null) {
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
    public function cropImage(int $width, int $height, int $x, int $y): Imagick
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
    public function cropThumbnailImage(int $width, int $height): Imagick
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
     * @param  int                   $degrees
     * @param  ?Color\ColorInterface $bgColor
     * @return Imagick
     */
    public function rotate(int $degrees, ?Color\ColorInterface $bgColor = null): Imagick
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
    public function flip(): Imagick
    {
        $this->resource->flipImage();
        return $this;
    }

    /**
     * Method to flip the image over the y-axis
     *
     * @return Imagick
     */
    public function flop(): Imagick
    {
        $this->resource->flopImage();
        return $this;
    }

    /**
     * Get the image adjust object
     *
     * @return Adjust\AdjustInterface
     */
    public function adjust(): Adjust\AdjustInterface
    {
        if ($this->adjust === null) {
            $this->adjust = new Adjust\Imagick($this);
        }
        if ($this->adjust->getImage() === null) {
            $this->adjust->setImage($this);
        }

        return $this->adjust;
    }

    /**
     * Get the image draw object
     *
     * @return Draw\DrawInterface
     */
    public function draw(): Draw\DrawInterface
    {
        if ($this->draw === null) {
            $this->draw = new Draw\Imagick($this);
        }
        if ($this->draw->getImage() === null) {
            $this->draw->setImage($this);
        }
        return $this->draw;
    }

    /**
     * Get the image effect object
     *
     * @return Effect\EffectInterface
     */
    public function effect(): Effect\EffectInterface
    {
        if ($this->effect === null) {
            $this->effect = new Effect\Imagick($this);
        }
        if ($this->effect->getImage() === null) {
            $this->effect->setImage($this);
        }
        return $this->effect;
    }

    /**
     * Get the image filter object
     *
     * @return Filter\FilterInterface
     */
    public function filter(): Filter\FilterInterface
    {
        if ($this->filter === null) {
            $this->filter = new Filter\Imagick($this);
        }
        if ($this->filter->getImage() === null) {
            $this->filter->setImage($this);
        }
        return $this->filter;
    }

    /**
     * Get the image layer object
     *
     * @return Layer\LayerInterface
     */
    public function layer(): Layer\LayerInterface
    {
        if ($this->layer === null) {
            $this->layer = new Layer\Imagick($this);
        }
        if ($this->layer->getImage() === null) {
            $this->layer->setImage($this);
        }
        return $this->layer;
    }

    /**
     * Get the image type object
     *
     * @return Type\TypeInterface
     */
    public function type(): Type\TypeInterface
    {
        if ($this->type === null) {
            $this->type = new Type\Imagick($this);
        }
        if ($this->type->getImage() === null) {
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
    public function convert(string $to): Imagick
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
     * @param  ?string $to
     * @param  ?int    $quality
     * @throws Exception
     * @return void
     */
    public function writeToFile(?string $to = null, ?int $quality = null): void
    {
        if (($this->resource === null) || (($this->resource !== null) && ($this->resource->count() == 0))) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if ($quality !== null) {
            $this->setQuality($quality);
        }

        if ($this->compression !== null) {
            $this->resource->setImageCompression($this->compression);
        }

        if (((int)$this->quality < 0) || ((int)$this->quality > 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        $this->resource->setImageCompressionQuality($this->quality);

        if ($to === null) {
            $to = ($this->name !== null) ? basename($this->name) : 'pop-image.' . $this->format;
        } else {
            $this->name = $to;
        }

        $this->resource->writeImage($to);
    }

    /**
     * Output the image object directly to HTTP
     *
     * @param  ?int    $quality
     * @param  ?string $to
     * @param  bool    $download
     * @param  bool    $sendHeaders
     * @param  array   $headers
     * @throws Exception
     * @return void
     */
    public function outputToHttp(
        ?int $quality = null, ?string $to = null, bool $download = false, bool $sendHeaders = true, array $headers = []
    ): void
    {
        if (($this->resource === null) || (($this->resource !== null) && ($this->resource->count() == 0))) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if ($quality !== null) {
            $this->setQuality($quality);
        }

        if (((int)$this->quality < 0) || ((int)$this->quality > 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        if ($this->compression !== null) {
            $this->resource->setImageCompression($this->compression);
        }

        $this->resource->setImageCompressionQuality($this->quality);

        if ($to === null) {
            $to = ($this->name !== null) ? basename($this->name) : 'pop-image.' . strtolower($this->format);
        }

        $this->sendHeaders($to, $download, $headers);
        echo ($this->resource->getNumberImages() > 0) ? $this->resource->getImagesBlob() : $this->resource;
    }

    /**
     * Destroy the image object and the related image file directly
     *
     * @param  bool $delete
     * @return void
     */
    public function destroy(bool $delete = false): void
    {
        if ($this->resource !== null) {
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
     * @param  ?Color\ColorInterface $color
     * @param  int                   $alpha
     * @throws ImagickPixelException
     * @return ImagickPixel
     */
    public function createColor(?Color\ColorInterface $color = null, int $alpha = 100): ImagickPixel
    {
        if ($color === null) {
            $color = new Color\Rgb(0, 0, 0);
        }

        if (!($color instanceof Color\Rgb)) {
            $color = $color->toRgb();
        }

        if ($alpha < 100) {
            $color->setA($alpha / 100);
        }

        return new ImagickPixel($color->render(Color\Rgb::CSS));
    }

    /**
     * Output the image
     *
     * @return string
     */
    public function __toString(): string
    {
        $this->sendHeaders();
        echo ($this->resource->getNumberImages() > 0) ? $this->resource->getImagesBlob() : $this->resource;
        return '';
    }

}