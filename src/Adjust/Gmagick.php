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
namespace Pop\Image\Adjust;

/**
 * Adjust class for Gmagick
 *
 *  This class has been deprecated as of 2/6/2020 and will no longer be maintained.
 *  Please use the Imagick classes instead.
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 * @deprecated
 */
class Gmagick extends AbstractAdjust
{

    /**
     * Method to adjust the hue of the image.
     *
     * @param  int $amount
     * @return Gmagick
     */
    public function hue($amount)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateimage(100, 100, $amount);
        }
        return $this;
    }

    /**
     * Method to adjust the saturation of the image.
     *
     * @param  int $amount
     * @return Gmagick
     */
    public function saturation($amount)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateimage(100, $amount, 100);
        }
        return $this;
    }

    /**
     * Adjust the image brightness
     *
     * @param  int $amount
     * @return Gmagick
     */
    public function brightness($amount)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateimage($amount, 100, 100);
        }
        return $this;
    }

    /**
     * Method to adjust the HSB of the image altogether.
     *
     * @param  int $h
     * @param  int $s
     * @param  int $b
     * @return Gmagick
     */
    public function hsb($h, $s, $b)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateimage($h, $s, $b);
        }
        return $this;
    }

    /**
     * Method to adjust the levels of the image using a 0 - 255 range.
     *
     * @param  int   $black
     * @param  float $gamma
     * @param  int   $white
     * @return Gmagick
     */
    public function level($black, $gamma, $white)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->levelimage($black, $gamma, $white);
        }
        return $this;
    }

    /**
     * Adjust the image contrast
     *
     * @param  int $amount
     * @return Gmagick
     */
    public function contrast($amount)
    {
        if ($this->hasImage()) {
            if ($amount > 0) {
                for ($i = 1; $i <= $amount; $i++) {
                    $this->image->getResource()->normalizeimage(\Gmagick::CHANNEL_ALL);
                }
            }
        }

        return $this;
    }

    /**
     * Adjust the image desaturate
     *
     * @return Gmagick
     */
    public function desaturate()
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateimage(100, 0, 100);
        }
        return $this;
    }

}
