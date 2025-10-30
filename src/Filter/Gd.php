<?php
/**
 * Pop PHP Framework (https://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2026 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Filter;

use Pop\Color\Color;

/**
 * Filter class for Gd
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2026 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.3
 */
class Gd extends AbstractFilter
{

    /**
     * Blur the image
     *
     * @param  int $amount
     * @param  int $type
     * @return Gd
     */
    public function blur(int $amount, int $type = IMG_FILTER_GAUSSIAN_BLUR): Gd
    {
        if ($this->hasImage()) {
            for ($i = 1; $i <= $amount; $i++) {
                imagefilter($this->image->getResource(), $type);
            }
        }

        return $this;
    }

    /**
     * Sharpen the image.
     *
     * @param  int $amount
     * @return Gd
     */
    public function sharpen(int $amount): Gd
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_SMOOTH, (0 - $amount));
        }
        return $this;
    }

    /**
     * Create a negative of the image
     *
     * @return Gd
     */
    public function negate(): Gd
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_NEGATE);
        }
        return $this;
    }

    /**
     * Colorize the image
     *
     * @param  Color\Rgb $color
     * @return Gd
     */
    public function colorize(Color\Rgb $color): Gd
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_COLORIZE, $color->getR(), $color->getG(), $color->getB());
        }
        return $this;
    }

    /**
     * Pixelate the image
     *
     * @param  int $px
     * @return Gd
     */
    public function pixelate(int $px): Gd
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_PIXELATE, $px, true);
        }
        return $this;
    }

    /**
     * Apply a pencil/sketch effect to the image
     *
     * @return Gd
     */
    public function pencil(): Gd
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_MEAN_REMOVAL);
        }
        return $this;
    }

}
