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
 * Abstract factory class
 *
 * @category   Pop
 * @package    Pop_Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.0
 */
abstract class AbstractImageFactory implements ImageFactoryInterface
{

    /**
     * Load an existing image as a resource and return the image object
     *
     * @param  string $image
     * @return mixed
     */
    abstract public function load($image);

    /**
     * Create a new image resource and return the image object
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $image
     * @return mixed
     */
    abstract public function create($width, $height, $image = null);

}
