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
namespace Pop\Image\Draw;

/**
 * Draw class for Gd
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2019 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.0
 */
class Gd extends AbstractDraw
{

    /**
     * Opacity
     * @var int
     */
    protected $opacity = 0;

    /**
     * Set the opacity
     *
     * @param  int $opacity
     * @return Gd
     */
    public function setOpacity($opacity)
    {
        $this->opacity = (int)round((127 - (127 * ($opacity / 100))));
        return $this;
    }

    /**
     * Draw a line on the image.
     *
     * @param  int $x1
     * @param  int $y1
     * @param  int $x2
     * @param  int $y2
     * @return Gd
     */
    public function line($x1, $y1, $x2, $y2)
    {
        $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
            $this->image->createColor($this->strokeColor, $this->opacity);

        // Draw the line.
        imagesetthickness($this->image->getResource(), (($this->strokeWidth == 0) ? 1 : $this->strokeWidth));
        imageline($this->image->getResource(), $x1, $y1, $x2, $y2, $strokeColor);

        return $this;
    }

    /**
     * Draw a rectangle on the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return Gd
     */
    public function rectangle($x, $y, $w, $h = null)
    {
        $x2 = $x + $w;
        $y2 = $y + ((null === $h) ? $w : $h);

        if (null !== $this->fillColor) {
            $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                $this->image->createColor($this->fillColor, $this->opacity);

            imagefilledrectangle($this->image->getResource(), $x, $y, $x2, $y2, $fillColor);
        }

        if ($this->strokeWidth > 0) {
            $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                $this->image->createColor($this->strokeColor, $this->opacity);
            imagesetthickness($this->image->getResource(), $this->strokeWidth);
            imagerectangle($this->image->getResource(), $x, $y, $x2, $y2, $strokeColor);
        }

        return $this;
    }

    /**
     * Draw a square on the image.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @return Gd
     */
    public function square($x, $y, $w)
    {
        return $this->rectangle($x, $y, $w, $w);
    }

    /**
     * Draw an ellipse on the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return Gd
     */
    public function ellipse($x, $y, $w, $h = null)
    {
        $wid = $w;
        $hgt = (null === $h) ? $w : $h;

        if (null !== $this->fillColor) {
            $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                $this->image->createColor($this->fillColor, $this->opacity);
            imagefilledellipse($this->image->getResource(), $x, $y, $wid, $hgt, $fillColor);
        }

        if ($this->strokeWidth > 0) {
            $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                $this->image->createColor($this->strokeColor, $this->opacity);

            imageellipse($this->image->getResource(), $x, $y, ($wid + $this->strokeWidth), ($hgt + $this->strokeWidth), $strokeColor);
        }

        return $this;
    }

    /**
     * Method to add a circle to the image.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @return Gd
     */
    public function circle($x, $y, $w)
    {
        return $this->ellipse($x, $y, $w, $w);
    }

    /**
     * Draw an arc on the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $start
     * @param  int $end
     * @param  int $w
     * @param  int $h
     * @return Gd
     */
    public function arc($x, $y, $start, $end, $w, $h = null)
    {
        if ($this->strokeWidth == 0) {
            $this->setStrokeWidth(1);
        }

        $wid = $w;
        $hgt = (null === $h) ? $w : $h;

        $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
            $this->image->createColor($this->strokeColor, $this->opacity);

        imagesetthickness($this->image->getResource(), $this->strokeWidth);
        imagearc($this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $strokeColor);

        return $this;
    }

    /**
     * Draw a chord on the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $start
     * @param  int $end
     * @param  int $w
     * @param  int $h
     * @return Gd
     */
    public function chord($x, $y, $start, $end, $w, $h = null)
    {
        $wid = $w;
        $hgt = (null === $h) ? $w : $h;

        if (null !== $this->fillColor) {
            $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                $this->image->createColor($this->fillColor, $this->opacity);
            imagefilledarc($this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $fillColor, IMG_ARC_CHORD);
        }

        if ($this->strokeWidth > 0) {
            $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                $this->image->createColor($this->strokeColor, $this->opacity);

            imagesetthickness($this->image->getResource(), $this->strokeWidth);
            imagefilledarc($this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $strokeColor, IMG_ARC_EDGED|IMG_ARC_CHORD|IMG_ARC_NOFILL);
        }

        return $this;
    }

    /**
     * Draw a slice on the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $start
     * @param  int $end
     * @param  int $w
     * @param  int $h
     * @return Gd
     */
    public function pie($x, $y, $start, $end, $w, $h = null)
    {
        $wid = $w;
        $hgt = (null === $h) ? $w : $h;

        if (null !== $this->fillColor) {
            $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                $this->image->createColor($this->fillColor, $this->opacity);
            imagefilledarc($this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $fillColor, IMG_ARC_PIE);
        }

        if ($this->strokeWidth > 0) {
            $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                $this->image->createColor($this->strokeColor, $this->opacity);

            imagesetthickness($this->image->getResource(), $this->strokeWidth);
            imagefilledarc($this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $strokeColor, IMG_ARC_EDGED|IMG_ARC_PIE|IMG_ARC_NOFILL);
        }

        return $this;
    }

    /**
     * Draw a polygon on the image.
     *
     * @param  array   $points
     * @return Gd
     */
    public function polygon($points)
    {
        $realPoints = [];
        foreach ($points as $coord) {
            if (isset($coord['x']) && isset($coord['y'])) {
                $realPoints[] = $coord['x'];
                $realPoints[] = $coord['y'];
            }
        }

        if (null !== $this->fillColor) {
            $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                $this->image->createColor($this->fillColor, $this->opacity);
            imagefilledpolygon($this->image->getResource(), $realPoints, count($points), $fillColor);
        }

        if ($this->strokeWidth > 0) {
            $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                $this->image->createColor($this->strokeColor, $this->opacity);

            imagesetthickness($this->image->getResource(), $this->strokeWidth);
            imagepolygon($this->image->getResource(), $realPoints, count($points), $strokeColor);
        }

        return $this;
    }

}
