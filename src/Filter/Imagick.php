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
 * Filter class for Imagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2026 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.3
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
    public function blur(mixed $radius = 0, mixed $sigma = 0, int $channel = \Imagick::CHANNEL_ALL): Imagick
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
    public function adaptiveBlur(mixed $radius = 0, mixed $sigma = 0, int $channel = \Imagick::CHANNEL_DEFAULT): Imagick
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
    public function gaussianBlur(mixed $radius = 0, mixed $sigma = 0, int $channel = \Imagick::CHANNEL_ALL): Imagick
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
    public function motionBlur(mixed $radius = 0, mixed $sigma = 0, int $angle = 0, int $channel = \Imagick::CHANNEL_DEFAULT): Imagick
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
    public function sharpen(mixed $radius = 0, mixed $sigma = 0, int $channel = \Imagick::CHANNEL_ALL): Imagick
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
    public function negate(): Imagick
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
    public function paint(int $radius): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->oilPaintImage($radius);
        }
        return $this;
    }

    /**
     * Apply a posterize effect to the image
     *
     * @param  int  $levels
     * @param  bool $dither
     * @return Imagick
     */
    public function posterize(int $levels, bool $dither = false): Imagick
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
    public function noise(int $type = \Imagick::NOISE_MULTIPLICATIVEGAUSSIAN, int $channel = \Imagick::CHANNEL_DEFAULT): Imagick
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
    public function diffuse(int $radius): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->spreadImage($radius);
        }
        return $this;
    }

    /**
     * Apply a skew effect to the image
     *
     * @param  int                   $x
     * @param  int                   $y
     * @param  ?Color\ColorInterface $color
     * @return Imagick
     */
    public function skew(int $x, int $y, ?Color\ColorInterface $color = null): Imagick
    {
        if ($this->hasImage()) {
            if ($color === null) {
                $color = new Color\Rgb(255, 255, 255);
            }
            if (!($color instanceof Color\Rgb)) {
                $color = $color->toRgb();
            }
            $this->image->getResource()->shearImage($color->render(Color\Rgb::CSS), $x, $y);
        }

        return $this;
    }

    /**
     * Apply a swirl effect to the image
     *
     * @param  int $degrees
     * @return Imagick
     */
    public function swirl(int $degrees): Imagick
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
    public function wave(mixed $amp, mixed $length): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->waveImage($amp, $length);
        }
        return $this;
    }

    /**
     * Apply a mosaic pixelate effect to the image
     *
     * @param  int  $w
     * @param  ?int $h
     * @return Imagick
     */
    public function pixelate(int $w, ?int $h = null): Imagick
    {
        if ($this->hasImage()) {
            $x = $this->image->getWidth() / $w;
            $y = $this->image->getHeight() / (($h === null) ? $w : $h);

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
    public function pencil(mixed $radius, mixed $sigma, mixed $angle): Imagick
    {
        if ($this->hasImage()) {
            $this->image->getResource()->sketchImage($radius, $sigma, $angle);
        }
        return $this;
    }

}
