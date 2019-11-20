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
 * Filter class for Imagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
class Imagick extends AbstractFilter
{

    /**
     * Blur the image.
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  int   $channel
     * @return Imagick
     */
    public function blur($radius = 0, $sigma = 0, $channel = \Imagick::CHANNEL_ALL)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->blurImage($radius, $sigma, $channel);
        }
        return $this;
    }

    /**
     * Blur the image.
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  int   $channel
     * @return Imagick
     */
    public function adaptiveBlur($radius = 0, $sigma = 0, $channel = \Imagick::CHANNEL_DEFAULT)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->adaptiveBlurImage($radius, $sigma, $channel);
        }
        return $this;
    }

    /**
     * Blur the image.
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  int   $channel
     * @return Imagick
     */
    public function gaussianBlur($radius = 0, $sigma = 0, $channel = \Imagick::CHANNEL_ALL)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->gaussianBlurImage($radius, $sigma, $channel);
        }
        return $this;
    }

    /**
     * Blur the image.
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  int   $angle
     * @param  int   $channel
     * @return Imagick
     */
    public function motionBlur($radius = 0, $sigma = 0, $angle = 0, $channel = \Imagick::CHANNEL_DEFAULT)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->motionBlurImage($radius, $sigma, $angle, $channel);
        }
        return $this;
    }

    /**
     * Sharpen the image
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  int   $channel
     * @return Imagick
     */
    public function sharpen($radius = 0, $sigma = 0, $channel = \Imagick::CHANNEL_ALL)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->sharpenImage($radius, $sigma, $channel);
        }
        return $this;
    }

    /**
     * Create a negative of the image
     *
     * @return Imagick
     */
    public function negate()
    {
        if ($this->hasImage()) {
            $this->image->getResource()->negateImage(false);
        }
        return $this;
    }

    /**
     * Apply an oil paint effect to the image using the pixel radius threshold
     *
     * @param  int $radius
     * @return Imagick
     */
    public function paint($radius)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->oilPaintImage($radius);
        }
        return $this;
    }

    /**
     * Apply a posterize effect to the image
     *
     * @param  int     $levels
     * @param  boolean $dither
     * @return Imagick
     */
    public function posterize($levels, $dither = false)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->posterizeImage($levels, $dither);
        }
        return $this;
    }

    /**
     * Apply a noise effect to the image
     *
     * @param  int $type
     * @param  int $channel
     * @return Imagick
     */
    public function noise($type = \Imagick::NOISE_MULTIPLICATIVEGAUSSIAN, $channel = \Imagick::CHANNEL_DEFAULT)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->addNoiseImage($type, $channel);
        }
        return $this;
    }

    /**
     * Apply a diffusion effect to the image
     *
     * @param  int $radius
     * @return Imagick
     */
    public function diffuse($radius)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->spreadImage($radius);
        }
        return $this;
    }

    /**
     * Apply a skew effect to the image
     *
     * @param  int                  $x
     * @param  int                  $y
     * @param  Color\ColorInterface $color
     * @return Imagick
     */
    public function skew($x, $y, Color\ColorInterface $color = null)
    {
        if ($this->hasImage()) {
            if (null === $color) {
                $color = new Color\Rgb(255, 255, 255);
            }
            if (!($color instanceof Color\Rgb)) {
                $color = $color->toRgb();
            }
            $this->image->getResource()->shearImage('rgb(' . $color . ')', $x, $y);
        }

        return $this;
    }

    /**
     * Apply a swirl effect to the image
     *
     * @param  int $degrees
     * @return Imagick
     */
    public function swirl($degrees)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->swirlImage($degrees);
        }
        return $this;
    }

    /**
     * Apply a wave effect to the image
     *
     * @param  mixed $amp
     * @param  mixed $length
     * @return Imagick
     */
    public function wave($amp, $length)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->waveImage($amp, $length);
        }
        return $this;
    }

    /**
     * Apply a mosaic pixelate effect to the image
     *
     * @param  int $w
     * @param  int $h
     * @return Imagick
     */
    public function pixelate($w, $h = null)
    {
        if ($this->hasImage()) {
            $x = $this->image->getWidth() / $w;
            $y = $this->image->getHeight() / ((null === $h) ? $w : $h);

            $this->image->getResource()->scaleImage($x, $y);
            $this->image->getResource()->scaleImage($this->image->getWidth(), $this->image->getHeight());
        }

        return $this;
    }

    /**
     * Apply a pencil/sketch effect to the image
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  mixed $angle
     * @return Imagick
     */
    public function pencil($radius, $sigma, $angle)
    {
        if ($this->hasImage()) {
            $this->image->getResource()->sketchImage($radius, $sigma, $angle);
        }
        return $this;
    }

}
