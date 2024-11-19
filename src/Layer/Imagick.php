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

use ImagickException;

/**
 * Layer class for Imagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.0
 */
class Imagick extends AbstractLayer
{

    /**
     * Overlay style
     * @var int
     */
    protected int $overlay = \Imagick::COMPOSITE_ATOP;

    /**
     * Get the overlay
     *
     * @return int
     */
    public function getOverlay(): int
    {
        return $this->overlay;
    }

    /**
     * Get the overlay
     *
     * @param  int $overlay
     * @return Imagick
     */
    public function setOverlay(int $overlay): Imagick
    {
        $this->overlay = $overlay;
        return $this;
    }

    /**
     * Overlay an image onto the current image.
     *
     * @param  string $image
     * @param  int    $x
     * @param  int    $y
     * @throws ImagickException
     * @return Imagick
     */
    public function overlay(string $image, int $x = 0, int $y = 0): Imagick
    {
        if ($this->hasImage()) {
            $overlayImage = new \Imagick($image);
            $this->image->getResource()->compositeImage($overlayImage, $this->overlay, $x, $y);
        }

        return $this;
    }

    /**
     * Flatten the image layers
     *
     * @param  int $method
     * @return Imagick
     */
    public function flatten(int $method = \Imagick::LAYERMETHOD_FLATTEN): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->mergeImageLayers($method);
        }
        return $this;
    }

}
