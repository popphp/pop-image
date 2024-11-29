<?php
/**
 * Pop PHP Framework (https://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image;

/**
 * Image Imagick factory class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.1
 */
class Imagick
{

    /**
     * Get the available image adapters
     *
     * @return array
     */
    public static function getAvailableAdapters(): array
    {
        return Image::getAvailableAdapters();
    }

    /**
     * Determine if the Imagick adapter is available
     *
     * @return bool
     */
    public static function isAvailable(): bool
    {
        return Image::isAvailable('imagick');
    }

    /**
     * Load the image resource from the existing image file into a Imagick object
     *
     * @param  string $image
     * @return Adapter\Imagick
     */
    public static function load(string $image): Adapter\Imagick
    {
        return new Adapter\Imagick($image);
    }

    /**
     * Load the image resource from data into a Imagick object
     *
     * @param  string  $data
     * @param  ?string $name
     * @return Adapter\Imagick
     */
    public static function loadFromString(string $data, ?string $name = null): Adapter\Imagick
    {
        $imagick = new Adapter\Imagick();
        $imagick->loadFromString($data, $name);
        return $imagick;
    }

    /**
     * Create an Imagick adapter object from an existing image
     *
     * @param  int     $width
     * @param  int     $height
     * @param  ?string $image
     * @return Adapter\Imagick
     */
    public static function create(int $width, int $height, ?string $image = null): Adapter\Imagick
    {
        return new Adapter\Imagick($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Imagick object
     *
     * @param  int     $width
     * @param  int     $height
     * @param  ?string $image
     * @return Adapter\Imagick
     */
    public static function createIndex(int $width, int $height, ?string $image = null): Adapter\Imagick
    {
        $imagick = new Adapter\Imagick();
        $imagick->createIndex($width, $height, $image);
        return $imagick;
    }

}
