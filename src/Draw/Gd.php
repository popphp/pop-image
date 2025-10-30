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
namespace Pop\Image\Draw;

/**
 * Draw class for Gd
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2026 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.3
 */
class Gd extends AbstractDraw
{

    /**
     * Opacity
     * @var int
     */
    protected int|float|null $opacity = 0;

    /**
     * Set the opacity
     *
     * @param  int|float $opacity
     * @return Gd
     */
    public function setOpacity(int|float $opacity): Gd
    {
        $this->opacity = (int)round((127 - (127 * ($opacity / 100))));
        return $this;
    }

    /**
     * Draw a line on the image.
     *
     * @param  int|float $x1
     * @param  int|float $y1
     * @param  int|float $x2
     * @param  int|float $y2
     * @return Gd
     */
    public function line(int|float $x1, int|float $y1, int|float $x2, int|float $y2): Gd
    {
        if ($this->hasImage()) {
            $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                $this->image->createColor($this->strokeColor, $this->opacity);

            // Draw the line.
            imagesetthickness($this->image->getResource(), (($this->strokeWidth == 0) ? 1 : $this->strokeWidth));
            imageline($this->image->getResource(), $x1, $y1, $x2, $y2, $strokeColor);
        }
        return $this;
    }

    /**
     * Draw a rectangle on the image.
     *
     * @param  int|float  $x
     * @param  int|float  $y
     * @param  int|float  $w
     * @param  int|float|null $h
     * @return Gd
     */
    public function rectangle(int|float $x, int|float $y, int|float $w, int|float|null $h = null): Gd
    {
        if ($this->hasImage()) {
            $x2 = $x + $w;
            $y2 = $y + (($h === null) ? $w : $h);

            if ($this->fillColor !== null) {
                $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                    $this->image->createColor($this->fillColor, $this->opacity);

                imagefilledrectangle($this->image->getResource(), (int)$x, (int)$y, (int)$x2, (int)$y2, $fillColor);
            }

            if ($this->strokeWidth > 0) {
                $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                    $this->image->createColor($this->strokeColor, $this->opacity);
                imagesetthickness($this->image->getResource(), $this->strokeWidth);
                imagerectangle($this->image->getResource(), $x, $y, $x2, $y2, $strokeColor);
            }
        }

        return $this;
    }

    /**
     * Draw a square on the image.
     *
     * @param  int|float $x
     * @param  int|float $y
     * @param  int|float $w
     * @return Gd
     */
    public function square(int|float $x, int|float $y, int|float $w): Gd
    {
        return $this->rectangle($x, $y, $w, $w);
    }

    /**
     * Draw an ellipse on the image.
     *
     * @param  int|float  $x
     * @param  int|float  $y
     * @param  int|float  $w
     * @param  int|float|null $h
     * @return Gd
     */
    public function ellipse(int|float $x, int|float $y, int|float $w, int|float|null $h = null): Gd
    {
        if ($this->hasImage()) {
            $wid = $w;
            $hgt = ($h === null) ? $w : $h;

            if ($this->fillColor !== null) {
                $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                    $this->image->createColor($this->fillColor, $this->opacity);
                imagefilledellipse($this->image->getResource(), $x, $y, $wid, $hgt, $fillColor);
            }

            if ($this->strokeWidth > 0) {
                $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                    $this->image->createColor($this->strokeColor, $this->opacity);

                imageellipse($this->image->getResource(), $x, $y, ($wid + $this->strokeWidth), ($hgt + $this->strokeWidth), $strokeColor);
            }
        }

        return $this;
    }

    /**
     * Method to add a circle to the image.
     *
     * @param  int|float $x
     * @param  int|float $y
     * @param  int|float $w
     * @return Gd
     */
    public function circle(int|float $x, int|float $y, int|float $w): Gd
    {
        return $this->ellipse($x, $y, $w, $w);
    }

    /**
     * Draw an arc on the image.
     *
     * @param  int|float      $x
     * @param  int|float      $y
     * @param  int|float      $start
     * @param  int|float      $end
     * @param  int|float      $w
     * @param  int|float|null $h
     * @return Gd
     */
    public function arc(int|float $x, int|float $y, int|float $start, int|float $end, int|float $w, int|float|null $h = null): Gd
    {
        if ($this->hasImage()) {
            if ($this->strokeWidth == 0) {
                $this->setStrokeWidth(1);
            }

            $wid = $w;
            $hgt = ($h === null) ? $w : $h;

            $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                $this->image->createColor($this->strokeColor, $this->opacity);

            imagesetthickness($this->image->getResource(), $this->strokeWidth);
            imagearc($this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $strokeColor);
        }

        return $this;
    }

    /**
     * Draw a chord on the image.
     *
     * @param  int|float      $x
     * @param  int|float      $y
     * @param  int|float      $start
     * @param  int|float      $end
     * @param  int|float      $w
     * @param  int|float|null $h
     * @return Gd
     */
    public function chord(int|float $x, int|float $y, int|float $start, int|float $end, int|float $w, int|float|null $h = null): Gd
    {
        if ($this->hasImage()) {
            $wid = $w;
            $hgt = ($h === null) ? $w : $h;

            if ($this->fillColor !== null) {
                $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                    $this->image->createColor($this->fillColor, $this->opacity);
                imagefilledarc($this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $fillColor, IMG_ARC_CHORD);
            }

            if ($this->strokeWidth > 0) {
                $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                    $this->image->createColor($this->strokeColor, $this->opacity);

                imagesetthickness($this->image->getResource(), $this->strokeWidth);
                imagefilledarc(
                    $this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $strokeColor, IMG_ARC_EDGED | IMG_ARC_CHORD | IMG_ARC_NOFILL
                );
            }
        }

        return $this;
    }

    /**
     * Draw a slice on the image.
     *
     * @param  int|float      $x
     * @param  int|float      $y
     * @param  int|float      $start
     * @param  int|float      $end
     * @param  int|float      $w
     * @param  int|float|null $h
     * @return Gd
     */
    public function pie(int|float $x, int|float $y, int|float $start, int|float $end, int|float $w, int|float|null $h = null): Gd
    {
        if ($this->hasImage()) {
            $wid = $w;
            $hgt = ($h === null) ? $w : $h;

            if ($this->fillColor !== null) {
                $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                    $this->image->createColor($this->fillColor, $this->opacity);
                imagefilledarc($this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $fillColor, IMG_ARC_PIE);
            }

            if ($this->strokeWidth > 0) {
                $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                    $this->image->createColor($this->strokeColor, $this->opacity);

                imagesetthickness($this->image->getResource(), $this->strokeWidth);
                imagefilledarc(
                    $this->image->getResource(), $x, $y, $wid, $hgt, $start, $end, $strokeColor, IMG_ARC_EDGED | IMG_ARC_PIE | IMG_ARC_NOFILL
                );
            }
        }

        return $this;
    }

    /**
     * Draw a polygon on the image.
     *
     * @param  array   $points
     * @return Gd
     */
    public function polygon(array $points): Gd
    {
        if ($this->hasImage()) {
            $realPoints = [];
            foreach ($points as $coord) {
                if (isset($coord['x']) && isset($coord['y'])) {
                    $realPoints[] = $coord['x'];
                    $realPoints[] = $coord['y'];
                }
            }

            if ($this->fillColor !== null) {
                $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor) :
                    $this->image->createColor($this->fillColor, $this->opacity);
                imagefilledpolygon($this->image->getResource(), $realPoints, $fillColor);
            }

            if ($this->strokeWidth > 0) {
                $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor) :
                    $this->image->createColor($this->strokeColor, $this->opacity);

                imagesetthickness($this->image->getResource(), $this->strokeWidth);
                imagepolygon($this->image->getResource(), $realPoints, $strokeColor);
            }
        }

        return $this;
    }

}
