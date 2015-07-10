<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Factory;

/**
 * SVG image factory class
 *
 * @category   Pop
 * @package    Pop_Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.0
 */
class Svg extends AbstractImageFactory
{

    /**
     * Load an existing image as a resource and return the Svg image object
     *
     * @param  string $image
     * @return \Pop\Image\Svg
     */
    public function load($image)
    {
        return new \Pop\Image\Svg($image);
    }

    /**
     * Create a new image resource and return the Svg image object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return \Pop\Image\Svg
     */
    public function create($width, $height, $image = null)
    {
        return new \Pop\Image\Svg($width, $height, $image);
    }

}
