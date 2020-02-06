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
 * Image Gd factory class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
class Gd
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
     * Determine if the GD adapter is available
     *
     * @return boolean
     */
    public static function isAvailable()
    {
        return Image::isAvailable('gd');
    }

    /**
     * Load the image resource from the existing image file into a Gd object
     *
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function load($image)
    {
        return new Adapter\Gd($image);
    }

    /**
     * Load the image resource from data into a Gd object
     *
     * @param  string $data
     * @param  string $name
     * @return Adapter\Gd
     */
    public static function loadFromString($data, $name = null)
    {
        $gd = new Adapter\Gd();
        $gd->loadFromString($data, $name);
        return $gd;
    }

    /**
     * Create a new image resource and load it into a Gd object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function create($width, $height, $image = null)
    {
        return new Adapter\Gd($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Gd object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function createIndex($width, $height, $image = null)
    {
        $gd = new Adapter\Gd();
        $gd->createIndex($width, $height, $image);
        return $gd;
    }

}