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
 * Image Gmagick factory class
 *
 *  This class has been deprecated as of 2/6/2020 and will no longer be maintained.
 *  Please use the Imagick classes instead.
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 * @deprecated
 */
class Gmagick
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
     * Determine if the Gmagick adapter is available
     *
     * @return boolean
     */
    public static function isAvailable()
    {
        return Image::isAvailable('gmagick');
    }

    /**
     * Load the image resource from the existing image file into a Gmagick object
     *
     * @param  string $image
     * @return Adapter\Gmagick
     */
    public static function load($image)
    {
        return new Adapter\Gmagick($image);
    }

    /**
     * Load the image resource from data into a Gmagick object
     *
     * @param  string $data
     * @param  string $name
     * @return Adapter\Gmagick
     */
    public static function loadFromString($data, $name = null)
    {
        $gmagick = new Adapter\Gmagick();
        $gmagick->loadFromString($data, $name);
        return $gmagick;
    }

    /**
     * Create a new image resource and load it into a Gmagick object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Gmagick
     */
    public static function create($width, $height, $image = null)
    {
        return new Adapter\Gmagick($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Gmagick object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Gmagick
     */
    public static function createIndex($width, $height, $image = null)
    {
        $gmagick = new Adapter\Gmagick();
        $gmagick->createIndex($width, $height, $image);
        return $gmagick;
    }

}