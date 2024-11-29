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
 * Image factory class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.1
 */
class Image
{

    /**
     * Get the available image adapters
     *
     * @return array
     */
    public static function getAvailableAdapters(): array
    {
        return [
            'gd'      => function_exists('gd_info'),
            'imagick' => (class_exists('Imagick', false))
        ];
    }

    /**
     * Determine if the adapter is available
     *
     * @param  string $adapter
     * @return bool
     */
    public static function isAvailable(string $adapter): bool
    {
        $result = false;

        switch (strtolower($adapter)) {
            case 'gd':
                $result = function_exists('gd_info');
                break;
            case 'imagemagick':
            case 'imagick':
                $result = (class_exists('Imagick', false));
                break;
        }

        return $result;
    }

    /**
     * Load the image resource from the existing image file into a Gd object
     *
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function loadGd(string $image): Adapter\Gd
    {
        return Gd::load($image);
    }

    /**
     * Load the image resource from the existing image file into a Imagick object
     *
     * @param  string $image
     * @return Adapter\Imagick
     */
    public static function loadImagick(string $image): Adapter\Imagick
    {
        return Imagick::load($image);
    }

    /**
     * Load the image resource from data into a Gd object
     *
     * @param  string  $data
     * @param  ?string $name
     * @throws Adapter\Exception
     * @return Adapter\Gd
     */
    public static function loadGdFromString(string $data, ?string $name = null): Adapter\Gd
    {
        return Gd::loadFromString($data, $name);
    }

    /**
     * Load the image resource from data into a Imagick object
     *
     * @param  string  $data
     * @param  ?string $name
     * @return Adapter\Imagick
     */
    public static function loadImagickFromString(string $data, ?string $name = null): Adapter\Imagick
    {
        return Imagick::loadFromString($data, $name);
    }

    /**
     * Create a new image resource and load it into a Gd object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  ?string $image
     * @return Adapter\Gd
     */
    public static function createGd(int $width, int $height, ?string $image = null): Adapter\Gd
    {
        return Gd::create($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Gd object
     *
     * @param  int     $width
     * @param  int     $height
     * @param  ?string $image
     * @throws Adapter\Exception
     * @return Adapter\Gd
     */
    public static function createGdIndex(int $width, int $height, ?string $image = null): Adapter\Gd
    {
        return Gd::createIndex($width, $height, $image);
    }

    /**
     * Create a new image resource and load it into a Imagick object
     *
     * @param  int     $width
     * @param  int     $height
     * @param  ?string $image
     * @return Adapter\Imagick
     */
    public static function createImagick(int $width, int $height, ?string $image = null): Adapter\Imagick
    {
        return Imagick::create($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Imagick object
     *
     * @param  int     $width
     * @param  int     $height
     * @param  ?string $image
     * @return Adapter\Imagick
     */
    public static function createImagickIndex(int $width, int $height, ?string $image = null): Adapter\Imagick
    {
        return Imagick::createIndex($width, $height, $image);
    }

}
