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
namespace Pop\Image\Effect;

use Pop\Image\Color;

/**
 * Effect class for Gd
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
class Gd extends AbstractEffect
{

    /**
     * Draw a border around the image.
     *
     * @param  Color\ColorInterface $color
     * @param  int                  $w
     * @param  int                  $h
     * @return Gd
     */
    public function border(Color\ColorInterface $color, $w, $h = null)
    {
        if ($this->hasImage()) {
            $h = (null === $h) ? $w : $h;
            $width = $this->image->getWidth();
            $height = $this->image->getHeight();

            $this->image->draw()->setFillColor($color);
            $this->image->draw()->rectangle(0, 0, $width, $h);
            $this->image->draw()->rectangle(0, ($height - $h), $width, $height);
            $this->image->draw()->rectangle(0, 0, $w, $height);
            $this->image->draw()->rectangle(($width - $w), 0, $width, $height);
        }

        return $this;
    }

    /**
     * Flood the image with a color fill.
     *
     * @param  Color\ColorInterface $color
     * @return Gd
     */
    public function fill(Color\ColorInterface $color)
    {
        if ($this->hasImage()) {
            if ($this->image->isIndexed()) {
                imagefill($this->image->getResource(), 0, 0, $this->image->createColor($color));
            } else {
                imagefill($this->image->getResource(), 0, 0, $this->image->createColor($color, 0));
            }
        }
        return $this;
    }

    /**
     * Flood the image with a vertical color gradient.
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @return Gd
     */
    public function radialGradient(Color\ColorInterface $color1, Color\ColorInterface $color2)
    {
        if ($this->hasImage()) {
            if ($this->image->getHeight() > $this->image->getWidth()) {
                $tween = $this->image->getHeight();
                $tween = round($tween * ($this->image->getHeight() / $this->image->getWidth()));
            } else if ($this->image->getWidth() > $this->image->getHeight()) {
                $tween = $this->image->getWidth();
                $tween = round($tween * ($this->image->getWidth() / $this->image->getHeight()));
            } else {
                $tween = $this->image->getWidth();
                $tween = round($tween * 1.5);
            }

            $blend = $this->getBlend($color1, $color2, $tween);

            $x = round($this->image->getWidth() / 2);
            $y = round($this->image->getHeight() / 2);
            $w = $tween;
            $h = $tween;

            foreach ($blend['r'] as $i => $v) {
                $r = $v;
                $g = $blend['g'][$i];
                $b = $blend['b'][$i];
                $color = ($this->image->isIndexed()) ? $this->image->createColor(new Color\Rgb($r, $g, $b), null) :
                    $this->image->createColor(new Color\Rgb($r, $g, $b), 0);

                imagefilledellipse($this->image->getResource(), $x, $y, $w, $h, $color);
                $w--;
                $h--;
            }
        }

        return $this;
    }

    /**
     * Flood the image with a vertical color gradient.
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @return Gd
     */
    public function verticalGradient(Color\ColorInterface $color1, Color\ColorInterface $color2)
    {
        return $this->linearGradient($color1, $color2, true);
    }

    /**
     * Flood the image with a vertical color gradient.
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @return Gd
     */
    public function horizontalGradient(Color\ColorInterface $color1, Color\ColorInterface $color2)
    {
        return $this->linearGradient($color1, $color2, false);
    }

    /**
     * Flood the image with a color gradient.
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @param  boolean              $vertical
     * @throws Exception
     * @return Gd
     */
    public function linearGradient(Color\ColorInterface $color1, Color\ColorInterface $color2, $vertical = true)
    {
        if ($this->hasImage()) {
            $tween = ($vertical) ? $this->image->getHeight() : $this->image->getWidth();
            $blend = $this->getBlend($color1, $color2, $tween);

            foreach ($blend['r'] as $i => $v) {
                $r = $v;
                $g = $blend['g'][$i];
                $b = $blend['b'][$i];
                $color = ($this->image->isIndexed()) ? $this->image->createColor(new Color\Rgb($r, $g, $b), null) :
                    $this->image->createColor(new Color\Rgb($r, $g, $b), 0);
                if ($vertical) {
                    imageline($this->image->getResource(), 0, $i, $this->image->getWidth(), $i, $color);
                } else {
                    imageline($this->image->getResource(), $i, 0, $i, $this->image->getHeight(), $color);
                }
            }
        }

        return $this;
    }

}
