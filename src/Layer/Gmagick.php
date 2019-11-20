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
namespace Pop\Image\Layer;

/**
 * Layer class for Gmagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
class Gmagick extends AbstractLayer
{

    /**
     * Opacity
     * @var mixed
     */
    protected $opacity = 1.0;

    /**
     * Overlay style
     * @var int
     */
    protected $overlay = \Gmagick::COMPOSITE_ATOP;

    /**
     * Get the overlay
     *
     * @return int
     */
    public function getOverlay()
    {
        return $this->overlay;
    }

    /**
     * Get the overlay
     *
     * @param  int $overlay
     * @return Gmagick
     */
    public function setOverlay($overlay)
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
     * @return Gmagick
     */
    public function overlay($image, $x = 0, $y = 0)
    {
        if ($this->hasImage()) {
            $overlayImage = new \Gmagick($image);
            $this->image->getResource()->compositeimage($overlayImage, $this->overlay, $x, $y);
        }
        return $this;
    }

    /**
     * Flatten the image layers
     *
     * @return Gmagick
     */
    public function flatten()
    {

        if (($this->hasImage()) && (method_exists($this->image->getResource(), 'flattenImages'))) {
            $this->image->getResource()->flattenimages();
        }
        return $this;
    }

}
