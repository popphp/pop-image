<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2019 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Filter;

use Pop\Image\Color;

/**
 * Filter class for Gmagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2019 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.0
 */
class Gmagick extends AbstractFilter
{

    /**
     * Blur the image.
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  int   $channel
     * @return Gmagick
     */
    public function blur($radius = 0, $sigma = 0, $channel = \Gmagick::CHANNEL_ALL)
    {
        $this->image->getResource()->blurimage($radius, $sigma, $channel);
        return $this;
    }

    /**
     * Blur the image.
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  int   $angle
     * @return Gmagick
     */
    public function motionBlur($radius = 0, $sigma = 0, $angle = 0)
    {
        $this->image->getResource()->motionblurimage($radius, $sigma, $angle);
        return $this;
    }

    /**
     * Blur the image.
     *
     * @param  int $angle
     * @param  int $channel
     * @return Gmagick
     */
    public function radialBlur($angle = 0, $channel = \Gmagick::CHANNEL_ALL)
    {
        $this->image->getResource()->radialblurimage($angle, $channel);
        return $this;
    }

    /**
     * Sharpen the image
     *
     * @param  mixed $radius
     * @param  mixed $sigma
     * @param  int   $channel
     * @return Gmagick
     */
    public function sharpen($radius = 0, $sigma = 0, $channel = \Gmagick::CHANNEL_ALL)
    {
        $this->image->getResource()->sharpenimage($radius, $sigma, $channel);
        return $this;
    }

    /**
     * Create a negative of the image
     *
     * @return Gmagick
     */
    public function negate()
    {
        $this->image->getResource()->negateimage(false, \Gmagick::CHANNEL_ALL);
        return $this;
    }

    /**
     * Apply an oil paint effect to the image using the pixel radius threshold
     *
     * @param  int $radius
     * @return Gmagick
     */
    public function paint($radius)
    {
        $this->image->getResource()->oilpaintimage($radius);
        return $this;
    }

    /**
     * Apply a noise effect to the image
     *
     * @param  int $type
     * @return Gmagick
     */
    public function noise($type = \Gmagick::NOISE_MULTIPLICATIVEGAUSSIAN)
    {
        $this->image->getResource()->addnoiseimage($type);
        return $this;
    }

    /**
     * Apply a diffusion effect to the image
     *
     * @param  int $radius
     * @return Gmagick
     */
    public function diffuse($radius)
    {
        $this->image->getResource()->spreadimage($radius);
        return $this;
    }

    /**
     * Apply a skew effect to the image
     *
     * @param  int                  $x
     * @param  int                  $y
     * @param  Color\ColorInterface $color
     * @return Gmagick
     */
    public function skew($x, $y, Color\ColorInterface $color = null)
    {
        if (null === $color) {
            $color = new Color\Rgb(255, 255, 255);
        }
        if (!($color instanceof Color\Rgb)) {
            $color = $color->toRgb();
        }
        $this->image->getResource()->shearimage('rgb(' . $color . ')', $x, $y);
        return $this;
    }

    /**
     * Apply a skew effect to the image
     *
     * @param  int $threshold
     * @return Gmagick
     */
    public function solarize($threshold)
    {
        $this->image->getResource()->solarizeimage($threshold);
        return $this;
    }

    /**
     * Apply a swirl effect to the image
     *
     * @param  int $degrees
     * @return Gmagick
     */
    public function swirl($degrees)
    {
        $this->image->getResource()->swirlimage($degrees);
        return $this;
    }

    /**
     * Apply a mosaic pixelate effect to the image
     *
     * @param  int $w
     * @param  int $h
     * @return Gmagick
     */
    public function pixelate($w, $h = null)
    {
        $x = $this->image->getWidth() / $w;
        $y = $this->image->getHeight() / ((null === $h) ? $w : $h);

        $this->image->getResource()->scaleimage($x, $y);
        $this->image->getResource()->scaleimage($this->image->getWidth(), $this->image->getHeight());

        return $this;
    }

}
