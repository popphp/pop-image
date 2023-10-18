<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Adjust;

/**
 * Adjust class for Gd
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    4.0.0
 */
class Gd extends AbstractAdjust
{

    /**
     * Adjust the image brightness
     *
     * @param  int $amount
     * @return Gd
     */
    public function brightness(int $amount): Gd
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_BRIGHTNESS, $amount);
        }
        return $this;
    }

    /**
     * Adjust the image contrast
     *
     * @param  int $amount
     * @return Gd
     */
    public function contrast(int $amount): Gd
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_CONTRAST, (0 - $amount));
        }
        return $this;
    }

    /**
     * Adjust the image desaturate
     *
     * @return Gd
     */
    public function desaturate(): Gd
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_GRAYSCALE);
        }
        return $this;
    }

}
