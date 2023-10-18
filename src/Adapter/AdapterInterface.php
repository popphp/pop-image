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
 * Adapter interface
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    4.0.0
 */
interface AdapterInterface
{

    /**
     * Create the image resource
     *
     * @return void
     */
    public function createResource(): void;

    /**
     * Get the image resource
     *
     * @return mixed
     */
    public function getResource(): mixed;

    /**
     * Determine if there is an image resource
     *
     * @return bool
     */
    public function hasResource(): bool;

    /**
     * Get the image name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the image width
     *
     * @return int
     */
    public function getWidth(): int;

    /**
     * Get the image height
     *
     * @return int
     */
    public function getHeight(): int;

    /**
     * Get the image quality
     *
     * @return int
     */
    public function getQuality(): int;

    /**
     * Get the colorspace
     *
     * @return int
     */
    public function getColorspace(): int;

    /**
     * Determine if the image is index color
     *
     * @return bool
     */
    public function isIndexed(): bool;

    /**
     * Get the image EXIF data
     *
     * @return array
     */
    public function getExif(): array;

    /**
     * Determine if the image is grayscale
     *
     * @return bool
     */
    public function isGray(): bool;

    /**
     * Determine if the image is RGB
     *
     * @return bool
     */
    public function isRgb(): bool;

    /**
     * Determine if the image is CMYK
     *
     * @return bool
     */
    public function isCmyk(): bool;

    /**
     * Set the image quality
     *
     * @param  int $quality
     * @return static
     */
    public function setQuality(int $quality): static;

    /**
     * Load the image resource from the existing image file
     *
     * @param  ?string $name
     * @return AdapterInterface
     */
    public function load(?string $name = null): AdapterInterface;

    /**
     * Load the image resource from data
     *
     * @param  string $data
     * @param  string $name
     * @return AdapterInterface
     */
    public function loadFromString(string $data, ?string $name = null): AdapterInterface;

    /**
     * Create a new image resource
     *
     * @param  ?int    $width
     * @param  ?int    $height
     * @param  ?string $name
     * @return AdapterInterface
     */
    public function create(?int $width = null, ?int $height = null, ?string $name = null): AdapterInterface;

    /**
     * Create a new indexed image resource
     *
     * @param  ?int    $width
     * @param  ?int    $height
     * @param  ?string $name
     * @return AdapterInterface
     */
    public function createIndex(?int $width = null, ?int $height = null, ?string $name = null): AdapterInterface;

    /**
     * Resize the image object to the width parameter passed
     *
     * @param  int $w
     * @return AdapterInterface
     */
    public function resizeToWidth(int $w): AdapterInterface;

    /**
     * Resize the image object to the height parameter passed
     *
     * @param  int $h
     * @return AdapterInterface
     */
    public function resizeToHeight(int $h): AdapterInterface;

    /**
     * Resize the image object, allowing for the largest dimension
     * to be scaled to the value of the $px argument.
     *
     * @param  int $px
     * @return AdapterInterface
     */
    public function resize(int $px): AdapterInterface;

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument.
     *
     * @param  float $scale
     * @return AdapterInterface
     */
    public function scale(float $scale): AdapterInterface;

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
    public function crop(int $w, int $h, int $x = 0, int $y = 0): AdapterInterface;

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $offset argument allows for the
     * adjustment of the crop to select a certain area of the image to be cropped.
     *
     * @param  int  $px
     * @param  ?int $offset
     * @return AdapterInterface
     */
    public function cropThumb(int $px, ?int $offset = null): AdapterInterface;

    /**
     * Rotate the image object
     *
     * @param  int                   $degrees
     * @param  ?Color\ColorInterface $bgColor
     * @throws Exception
     * @return Gd
     */
    public function rotate(int $degrees, ?Color\ColorInterface $bgColor = null): AdapterInterface;

    /**
     * Method to flip the image over the x-axis
     *
     * @return AdapterInterface
     */
    public function flip(): AdapterInterface;

    /**
     * Method to flip the image over the y-axis
     *
     * @return AdapterInterface
     */
    public function flop(): AdapterInterface;

    /**
     * Get the image adjust object
     *
     * @return Adjust\AdjustInterface
     */
    public function adjust(): Adjust\AdjustInterface;

    /**
     * Get the image filter object
     *
     * @return Filter\FilterInterface
     */
    public function filter(): Filter\FilterInterface;

    /**
     * Get the image layer object
     *
     * @return Layer\LayerInterface
     */
    public function layer(): Layer\LayerInterface;

    /**
     * Get the image draw object
     *
     * @return Draw\DrawInterface
     */
    public function draw(): Draw\DrawInterface;

    /**
     * Get the image effect object
     *
     * @return Effect\EffectInterface
     */
    public function effect(): Effect\EffectInterface;

    /**
     * Get the image type object
     *
     * @return Type\TypeInterface
     */
    public function type(): Type\TypeInterface;

    /**
     * Convert the image object to another format
     *
     * @param  string $type
     * @throws Exception
     * @return AdapterInterface
     */
    public function convert(string $type): AdapterInterface;

    /**
     * Write the image object to a file on disk
     *
     * @param  ?string $to
     * @param  int     $quality
     * @throws Exception
     * @return void
     */
    public function writeToFile(?string $to = null, int $quality = 100): void;

    /**
     * Output the image object directly to HTTP
     *
     * @param  int     $quality
     * @param  ?string $to
     * @param  bool    $download
     * @param  bool    $sendHeaders
     * @throws Exception
     * @return void
     */
    public function outputToHttp(int $quality = 100, ?string $to = null, bool $download = false, bool $sendHeaders = true): void;

    /**
     * Destroy the image object and the related image file directly
     *
     * @param  bool $delete
     * @return void
     */
    public function destroy(bool $delete = false): void;

    /**
     * Create and return a color.
     *
     * @param  ?Color\ColorInterface $color
     * @param  int                  $alpha
     * @throws Exception
     * @return mixed
     */
    public function createColor(Color\ColorInterface $color = null, int $alpha = 100): mixed;

    /**
     * Send image headers the image
     *
     * @param  ?string $to
     * @param  bool    $download
     * @return void
     */
    public function sendHeaders(?string $to = null, bool $download = false): void;

    /**
     * Output the image
     *
     * @return string
     */
    public function __toString(): string;

}