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
namespace Pop\Image\Layer;

/**
 * Layer interface
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.1
 */
interface LayerInterface
{

    /**
     * Get the opacity
     *
     * @return mixed
     */
    public function getOpacity(): mixed;

    /**
     * Set the image opacity.
     *
     * @param  int|float $opacity
     * @return AbstractLayer
     */
    public function setOpacity(int|float $opacity): AbstractLayer;

}
