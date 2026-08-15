<?php
declare(strict_types=1);
/**
 * Pop PHP Framework (https://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2027 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
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
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2027 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    5.0.0
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
