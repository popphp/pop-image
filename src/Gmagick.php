<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image;

/**
 * Image Gmagick factory class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
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
     * Determine if the adapter is available
     *
     * @param  string $adapter
     * @return boolean
     */
    public static function isAvailable($adapter)
    {
        return Image::isAvailable($adapter);
    }

    /**
     * Create a Gmagick adapter object from an existing image
     *
     * @param  string $image
     * @return Adapter\Gmagick
     */
    public static function load($image)
    {
        return new Adapter\Gmagick($image);
    }

    /**
     * Create a Gmagick adapter object from an existing image
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
     * Create a Gmagick adapter object from an existing image
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

}