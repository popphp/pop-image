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
namespace Pop\Image\Filter;

use Pop\Image\Color;

/**
 * Filter class for Gd
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
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
    public function blur($amount, $type = IMG_FILTER_GAUSSIAN_BLUR)
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
    public function sharpen($amount)
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
    public function negate()
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
    public function colorize(Color\Rgb $color)
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
    public function pixelate($px)
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
    public function pencil()
    {
        if ($this->hasImage()) {
            imagefilter($this->image->getResource(), IMG_FILTER_MEAN_REMOVAL);
        }
        return $this;
    }

}
