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
 * Image factory class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
class Image
{

    /**
     * Get the available image adapters
     *
     * @return array
     */
    public static function getAvailableAdapters()
    {
        return [
            'gd'      => function_exists('gd_info'),
            'gmagick' => (class_exists('Gmagick', false)),
            'imagick' => (class_exists('Imagick', false))
        ];
    }

    /**
     * Determine if the adapter is available
     *
     * @param  string $adapter
     * @return boolean
     */
    public static function isAvailable($adapter)
    {
        $result = false;

        switch (strtolower($adapter)) {
            case 'gd':
                $result = function_exists('gd_info');
                break;
            case 'graphicsmagick':
            case 'gmagick':
                $result = (class_exists('Gmagick', false));
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
    public static function loadGd($image)
    {
        return Gd::load($image);
    }

    /**
     * Load the image resource from the existing image file into a Gmagick object
     *
     * @param  string $image
     * @return Adapter\Gmagick
     */
    public static function loadGmagick($image)
    {
        return Gmagick::load($image);
    }

    /**
     * Load the image resource from the existing image file into a Imagick object
     *
     * @param  string $image
     * @return Adapter\Imagick
     */
    public static function loadImagick($image)
    {
        return Imagick::load($image);
    }

    /**
     * Load the image resource from data into a Gd object
     *
     * @param  string $data
     * @param  string $name
     * @return Adapter\Gd
     */
    public static function loadGdFromString($data, $name = null)
    {
        return Gd::loadFromString($data, $name);
    }

    /**
     * Load the image resource from data into a Gmagick object
     *
     * @param  string $data
     * @param  string $name
     * @return Adapter\Gmagick
     */
    public static function loadGmagickFromString($data, $name = null)
    {
        return Gmagick::loadFromString($data, $name);
    }

    /**
     * Load the image resource from data into a Imagick object
     *
     * @param  string $data
     * @param  string $name
     * @return Adapter\Imagick
     */
    public static function loadImagickFromString($data, $name = null)
    {
        return Imagick::loadFromString($data, $name);
    }

    /**
     * Create a new image resource and load it into a Gd object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function createGd($width, $height, $image = null)
    {
        return Gd::create($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Gd object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Gd
     */
    public static function createGdIndex($width, $height, $image = null)
    {
        return Gd::createIndex($width, $height, $image);
    }

    /**
     * Create a new image resource and load it into a Gmagick object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Gmagick
     */
    public static function createGmagick($width, $height, $image = null)
    {
        return Gmagick::create($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Gmagick object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Gmagick
     */
    public static function createGmagickIndex($width, $height, $image = null)
    {
        return Gmagick::createIndex($width, $height, $image);
    }

    /**
     * Create a new image resource and load it into a Imagick object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Imagick
     */
    public static function createImagick($width, $height, $image = null)
    {
        return Imagick::create($width, $height, $image);
    }

    /**
     * Create a new indexed image resource and load it into a Imagick object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return Adapter\Imagick
     */
    public static function createImagickIndex($width, $height, $image = null)
    {
        return Imagick::createIndex($width, $height, $image);
    }

}