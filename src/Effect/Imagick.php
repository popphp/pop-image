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
namespace Pop\Image\Effect;

use Pop\Color\Color;
use ImagickException;

/**
 * Effect class for Imagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    4.0.0
 */
class Imagick extends AbstractEffect
{

    /**
     * Draw a border around the image.
     *
     * @param  Color\ColorInterface $color
     * @param  int|float            $w
     * @param  int|float|null       $h
     * @return Imagick
     */
    public function border(Color\ColorInterface $color, int|float $w = 1, int|float|null $h = null): Imagick
    {
        if ($this->hasImage()) {
            $h = ($h === null) ? $w : $h;
            $this->image->getResource()->borderImage($this->image->createColor($color), $w, $h);
        }
        return $this;
    }

    /**
     * Flood the image with a color fill.
     *
     * @param  Color\ColorInterface $color
     * @return Imagick
     */
    public function fill(Color\ColorInterface $color): Imagick
    {
        if ($this->hasImage()) {
            $draw = new \ImagickDraw();
            $draw->setFillColor($this->image->createColor($color));
            $draw->rectangle(0, 0, $this->image->getWidth(), $this->image->getHeight());
            $this->image->getResource()->drawImage($draw);
        }
        return $this;
    }

    /**
     * Flood the image with a vertical color gradient.
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @throws ImagickException
     * @return Imagick
     */
    public function radialGradient(Color\ColorInterface $color1, Color\ColorInterface $color2): Imagick
    {
        if ($this->hasImage()) {
            $im = new \Imagick();
            $width = round($this->image->getWidth() * 1.25);
            $height = round($this->image->getHeight() * 1.25);

            if (!($color1 instanceof Color\Rgb)) {
                $color1 = $color1->toRgb();
            }
            if (!($color2 instanceof Color\Rgb)) {
                $color2 = $color2->toRgb();
            }

            $im->newPseudoImage($width, $height, 'radial-gradient:' . $color1->toHex() . '-' . $color2->toHex());
            $this->image->getResource()->compositeImage(
                $im, \Imagick::COMPOSITE_ATOP,
                0 - round(($width - $this->image->getWidth()) / 2),
                0 - round(($height - $this->image->getHeight()) / 2)
            );
        }

        return $this;
    }

    /**
     * Flood the image with a vertical color gradient.
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @throws ImagickException
     * @return Imagick
     */
    public function verticalGradient(Color\ColorInterface $color1, Color\ColorInterface $color2): Imagick
    {
        if ($this->hasImage()) {
            $im = new \Imagick();

            if (!($color1 instanceof Color\Rgb)) {
                $color1 = $color1->toRgb();
            }
            if (!($color2 instanceof Color\Rgb)) {
                $color2 = $color2->toRgb();
            }

            $im->newPseudoImage(
                $this->image->getWidth(), $this->image->getHeight(), 'gradient:' . $color1->toHex() . '-' . $color2->toHex()
            );
            $this->image->getResource()->compositeImage($im, \Imagick::COMPOSITE_ATOP, 0, 0);
        }

        return $this;
    }

    /**
     * Flood the image with a vertical color gradient.
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @throws ImagickException
     * @return Imagick
     */
    public function horizontalGradient(Color\ColorInterface $color1, Color\ColorInterface $color2): Imagick
    {
        if ($this->hasImage()) {
            $im = new \Imagick();

            if (!($color1 instanceof Color\Rgb)) {
                $color1 = $color1->toRgb();
            }
            if (!($color2 instanceof Color\Rgb)) {
                $color2 = $color2->toRgb();
            }

            $im->newPseudoImage(
                $this->image->getHeight(), $this->image->getWidth(), 'gradient:' . $color1->toHex() . '-' . $color2->toHex()
            );
            $im->rotateImage('rgb(255, 255, 255)', -90);
            $this->image->getResource()->compositeImage($im, \Imagick::COMPOSITE_ATOP, 0, 0);
        }

        return $this;
    }

    /**
     * Flood the image with a color gradient.
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @param  bool                 $vertical
     * @throws ImagickException
     * @return Imagick
     */
    public function linearGradient(Color\ColorInterface $color1, Color\ColorInterface $color2, bool $vertical = true): Imagick
    {
        if ($this->hasImage()) {
            if ($vertical) {
                $this->verticalGradient($color1, $color2);
            } else {
                $this->horizontalGradient($color1, $color2);
            }
        }

        return $this;
    }

}
