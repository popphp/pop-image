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
namespace Pop\Image\Adjust;

/**
 * Adjust class for Imagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.1
 */
class Imagick extends AbstractAdjust
{

    /**
     * Method to adjust the hue of the image.
     *
     * @param  int $amount
     * @return Imagick
     */
    public function hue(int $amount): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateImage(100, 100, $amount);
        }
        return $this;
    }

    /**
     * Method to adjust the saturation of the image.
     *
     * @param  int $amount
     * @return Imagick
     */
    public function saturation(int $amount): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateImage(100, $amount, 100);
        }
        return $this;
    }

    /**
     * Adjust the image brightness
     *
     * @param  int $amount
     * @return Imagick
     */
    public function brightness(int $amount): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateImage($amount, 100, 100);
        }
        return $this;
    }

    /**
     * Method to adjust the HSB of the image altogether.
     *
     * @param  int $h
     * @param  int $s
     * @param  int $b
     * @return Imagick
     */
    public function hsb(int $h, int $s, int $b): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateImage($h, $s, $b);
        }
        return $this;
    }

    /**
     * Method to adjust the levels of the image using a 0 - 255 range.
     *
     * @param  int   $black
     * @param  float $gamma
     * @param  int   $white
     * @return Imagick
     */
    public function level(int $black, float $gamma, int $white): Imagick
    {
        if ($this->hasImage()) {
            $quantumRange = $this->image->getResource()->getQuantumRange();

            if ($black < 0) {
                $black = 0;
            }
            if ($white > 255) {
                $white = 255;
            }

            $blackPoint = ($black / 255) * $quantumRange['quantumRangeLong'];
            $whitePoint = ($white / 255) * $quantumRange['quantumRangeLong'];

            $this->image->getResource()->levelImage($blackPoint, $gamma, $whitePoint);
        }

        return $this;
    }

    /**
     * Adjust the image contrast
     *
     * @param  int $amount
     * @return Imagick
     */
    public function contrast(int $amount): Imagick
    {
        if ($this->hasImage()) {
            if ($amount > 0) {
                for ($i = 1; $i <= $amount; $i++) {
                    $this->image->getResource()->contrastImage(1);
                }
            } else if ($amount < 0) {
                for ($i = -1; $i >= $amount; $i--) {
                    $this->image->getResource()->contrastImage(0);
                }
            }
        }
        return $this;
    }

    /**
     * Adjust the image desaturate
     *
     * @return Imagick
     */
    public function desaturate(): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->modulateImage(100, 0, 100);
        }
        return $this;
    }

}
