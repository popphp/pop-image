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
namespace Pop\Image;

/**
 * Image Imagick factory class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
class Imagick
{

    /**
     * Get the available image adapters
     *
     * @return array
     */
    public static function getAvailableAdapters()
    {
        return Image::getAvailableAdapters();
    }

    /**
     * Determine if the Imagick adapter is available
     *
     * @return boolean
     */
    public static function isAvailable()
    {
        return Image::isAvailable('imagick');
    }

    /**
     * Load the image resource from the existing image file into a Imagick object
     *
     * @param  string $image
     * @return Adapter\Imagick
     */
    public static function load($image)
    {
        return new Adapter\Imagick($image);
    }

    /**
     * Load the image resource from data into a Imagick object
     *
     * @param  string $data
     * @param  string $name
     * @return Adapter\Imagick
     */
    public static function loadFromString($data, $name = null)
    {
        $imagick = new Adapter\Imagick();
        $imagick->loadFromString($data, $name);
        return $imagick;
    }

    /**
     * Create a Gmagick adapter object from an existing image
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Imagick
     */
    public static function create($width, $height, $image = null)
    {
        return new Adapter\Imagick($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Imagick object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Imagick
     */
    public static function createIndex($width, $height, $image = null)
    {
        $imagick = new Adapter\Imagick();
        $imagick->createIndex($width, $height, $image);
        return $imagick;
    }

}