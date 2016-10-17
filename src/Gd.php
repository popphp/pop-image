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
 * Image Gd factory class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
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
     * Create a GD adapter object from an existing image
     *
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function loadGd($image)
    {
        return Gd::load($image);
    }

    /**
     * Create a GD adapter object from an existing image
     *
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function load($image)
    {
        return new Adapter\Gd($image);
    }

    /**
     * Create a GD adapter object from an existing image
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
     * Create a GD adapter object from an existing image
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

}