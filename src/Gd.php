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
namespace Pop\Image;

/**
 * Image Gd factory class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    4.0.0
 */
class Gd
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
     * Determine if the GD adapter is available
     *
     * @return bool
     */
    public static function isAvailable(): bool
    {
        return Image::isAvailable('gd');
    }

    /**
     * Load the image resource from the existing image file into a Gd object
     *
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function load(string $image): Adapter\Gd
    {
        return new Adapter\Gd($image);
    }

    /**
     * Load the image resource from data into a Gd object
     *
     * @param  string  $data
     * @param  ?string $name
     * @throws Adapter\Exception
     * @return Adapter\Gd
     */
    public static function loadFromString(string $data, ?string $name = null): Adapter\Gd
    {
        $gd = new Adapter\Gd();
        $gd->loadFromString($data, $name);
        return $gd;
    }

    /**
     * Create a new image resource and load it into a Gd object
     *
     * @param  int     $width
     * @param  int     $height
     * @param  ?string $image
     * @return Adapter\Gd
     */
    public static function create(int $width, int $height, ?string $image = null): Adapter\Gd
    {
        return new Adapter\Gd($width, $height, $image);
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
    public static function createIndex(int $width, int $height, ?string $image = null): Adapter\Gd
    {
        $gd = new Adapter\Gd();
        $gd->createIndex($width, $height, $image);
        return $gd;
    }

}