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

/**
 * Gd adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    4.0.0
 */
class Gd extends AbstractAdapter
{

    /**
     * Create the image resource
     *
     * @return void
     */
    public function createResource(): void
    {
        $this->resource = null;
    }

    /**
     * Load the image resource from the existing image file
     *
     * @param  ?string $name
     * @throws Exception
     * @return Gd
     */
    public function load(?string $name = null): Gd
    {
        if ($name !== null) {
            $this->name = $name;
        }

        if (($this->name === null) || !file_exists($this->name)) {
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
     * @param  string  $data
     * @param  ?string $name
     * @throws Exception
     * @return Gd
     */
    public function loadFromString(string $data, ?string $name = null): Gd
    {
        if ($name !== null) {
            $this->name = $name;
        }

        $this->resource = @imagecreatefromstring($data);

        if ($this->resource === false) {
            throw new Exception('Error: Unable to load image resource');
        }

        $this->parseImage(getimagesizefromstring($data), $data);

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
     * @throws Exception
     * @return Gd
     */
    public function create(?int $width = null, ?int $height = null, ?string $name = null): Gd
    {
        if (($width !== null) && ($height !== null)) {
            $this->width  = $width;
            $this->height = $height;
        }

        if ($name !== null) {
            $this->name = $name;
        }

        if (($this->width === null) && ($this->height === null)) {
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
     * @param  ?int    $width
     * @param  ?int    $height
     * @param  ?string $name
     * @throws Exception
     * @return Gd
     */
    public function createIndex(?int $width = null, ?int $height = null, ?string $name = null): Gd
    {
        if (($width !== null) && ($height !== null)) {
            $this->width  = $width;
            $this->height = $height;
        }

        if ($name !== null) {
            $this->name = $name;
        }

        if (($this->width === null) && ($this->height === null)) {
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
    public function resizeToWidth(int $w): Gd
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
    public function resizeToHeight(int $h): Gd
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
    public function resize(int $px): Gd
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
    public function scale(float $scale): Gd
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
    public function crop(int $w, int $h, int $x = 0, int $y = 0): Gd
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
     * @param  int  $px
     * @param  ?int $offset
     * @return Gd
     */
    public function cropThumb(int $px, ?int $offset = null): Gd
    {
        $xOffset = 0;
        $yOffset = 0;
        $scale   = ($this->width > $this->height) ? ($px / $this->height) : ($px / $this->width);
        $w       = round($this->width * $scale);
        $h       = round($this->height * $scale);

        if ($offset !== null) {
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
     * @param  int                   $degrees
     * @param  ?Color\ColorInterface $bgColor
     * @param  ?int                  $alpha
     * @return Gd
     */
    public function rotate(int $degrees, ?Color\ColorInterface $bgColor = null, int $alpha = null): Gd
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
    public function flip(): Gd
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
    public function flop(): Gd
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
    public function adjust(): Adjust\AdjustInterface
    {
        if ($this->adjust === null) {
            $this->adjust = new Adjust\Gd($this);
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
            $this->draw = new Draw\Gd($this);
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
            $this->effect = new Effect\Gd($this);
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
            $this->filter = new Filter\Gd($this);
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
            $this->layer = new Layer\Gd($this);
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
            $this->type = new Type\Gd($this);
        }
        return $this->type;
    }

    /**
     * Convert the image object to another format
     *
     * @param  string $type
     * @throws Exception
     * @return Gd
     */
    public function convert(string $type): Gd
    {
        $type = strtolower($type);

        if (($type != 'jpg') && ($type != 'jpeg') && ($type != 'gif') && ($type != 'png')) {
            throw new Exception('Error: The image type must be a GIF, PNG or JPG');
        }

        if ($this->resource === null) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        switch ($type) {
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

        if (($this->name !== null) && (strpos($this->name, '.') !== false)) {
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
     * @param  ?string $to
     * @param  ?int    $quality
     * @throws Exception
     * @return void
     */
    public function writeToFile(?string $to = null, ?int $quality = null): void
    {
        if ($this->resource === null) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if ($quality !== null) {
            $this->setQuality($quality);
        }

        if (((int)$this->quality < 0) || ((int)$this->quality > 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        $this->format = strtolower($this->format);

        if ($to === null) {
            $to = ($this->name !== null) ? basename($this->name) : 'pop-image.' . $this->format;
        } else {
            $this->name = $to;
        }

        $this->generateImage((int)$this->quality, $to);
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
        if ($this->resource === null) {
            throw new Exception('Error: An image resource has not been created or loaded');
        }

        if ($quality !== null) {
            $this->setQuality($quality);
        }

        if (((int)$this->quality < 0) || ((int)$this->quality > 100)) {
            throw new \OutOfRangeException('Error: The quality parameter must be between 0 and 100');
        }

        $this->format = strtolower($this->format);

        if ($to === null) {
            $to = ($this->name !== null) ? basename($this->name) : 'pop-image.' . $this->format;
        }

        $this->sendHeaders($to, $download, $headers);
        $this->generateImage((int)$this->quality);
    }

    /**
     * Destroy the image object and the related image file directly
     *
     * @param  bool $delete
     * @return void
     */
    public function destroy(bool $delete = false): void
    {
        // Destroy the image resource.
        if ($this->resource !== null) {
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
     * @param  ?Color\ColorInterface $color
     * @param  ?int                  $alpha
     * @throws Exception
     * @return mixed
     */
    public function createColor(?Color\ColorInterface $color = null, ?int $alpha = null): mixed
    {
        if ($color === null) {
            $color = new Color\Rgb(0, 0, 0);
        }

        if (!($color instanceof Color\Rgb)) {
            $color = $color->toRgb();
        }

        $r = $color->getR();
        $g = $color->getG();
        $b = $color->getB();

        if ($alpha !== null) {
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
    public function __toString(): string
    {
        $quality = ($this->quality !== null) ? $this->quality : 100;
        $this->sendHeaders();
        $this->generateImage($quality);
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
    protected function copyImage(int $w, int $h, int $x = 0, int $y = 0): void
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
    protected function parseImage(array $size, string $data): void
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
     * @param  int     $quality
     * @param  ?string $to
     * @return void
     */
    protected function generateImage(int $quality, ?string $to = null): void
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