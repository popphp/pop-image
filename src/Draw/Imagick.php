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
namespace Pop\Image\Draw;

use ImagickDrawException;

/**
 * Draw class for Imagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.0
 */
class Imagick extends AbstractDraw
{

    /**
     * Opacity
     * @var int|float|null
     */
    protected int|float|null $opacity = 1.0;

    /**
     * Set the opacity
     *
     * @param  int|float $opacity
     * @return Imagick
     */
    public function setOpacity(int|float $opacity): Imagick
    {
        $this->opacity = $opacity;
        return $this;
    }

    /**
     * Draw a line on the image.
     *
     * @param  int $x1
     * @param  int $y1
     * @param  int $x2
     * @param  int $y2
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function line(int $x1, int $y1, int $x2, int $y2): Imagick
    {
        if ($this->hasImage()) {
            $draw = new \ImagickDraw();
            $draw->setStrokeColor($this->image->createColor($this->strokeColor, $this->opacity));
            $draw->setStrokeWidth(($this->strokeWidth === null) ? 1 : $this->strokeWidth);
            $draw->line($x1, $y1, $x2, $y2);
            $this->image->getResource()->drawImage($draw);
        }

        return $this;
    }

    /**
     * Draw a rectangle on the image.
     *
     * @param  int  $x
     * @param  int  $y
     * @param  int  $w
     * @param  ?int $h
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function rectangle(int $x, int $y, int $w, ?int $h = null): Imagick
    {
        if ($this->hasImage()) {
            $x2 = $x + $w;
            $y2 = $y + (($h === null) ? $w : $h);

            $draw = new \ImagickDraw();

            if ($this->fillColor !== null) {
                $draw->setFillColor($this->image->createColor($this->fillColor, $this->opacity));
            }

            if ($this->strokeWidth > 0) {
                $draw->setStrokeColor($this->image->createColor($this->strokeColor, $this->opacity));
                $draw->setStrokeWidth($this->strokeWidth);
            }

            $draw->rectangle($x, $y, $x2, $y2);
            $this->image->getResource()->drawImage($draw);
        }

        return $this;
    }

    /**
     * Draw a square on the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function square(int $x, int $y, int $w): Imagick
    {
        return $this->rectangle($x, $y, $w, $w);
    }

    /**
     * Draw a rounded rectangle on the image.
     *
     * @param  int  $x
     * @param  int  $y
     * @param  int  $w
     * @param  ?int $h
     * @param  ?int $rx
     * @param  ?int $ry
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function roundedRectangle(int $x, int $y, int $w, ?int $h = null, ?int $rx = 10, ?int $ry = null): Imagick
    {
        if ($this->hasImage()) {
            $x2 = $x + $w;
            $y2 = $y + (($h === null) ? $w : $h);
            if ($ry === null) {
                $ry = $rx;
            }

            $draw = new \ImagickDraw();

            if ($this->fillColor !== null) {
                $draw->setFillColor($this->image->createColor($this->fillColor, $this->opacity));
            }

            if ($this->strokeWidth > 0) {
                $draw->setStrokeColor($this->image->createColor($this->strokeColor, $this->opacity));
                $draw->setStrokeWidth($this->strokeWidth);
            }

            $draw->roundRectangle($x, $y, $x2, $y2, $rx, $ry);
            $this->image->getResource()->drawImage($draw);
        }

        return $this;
    }

    /**
     * Draw a rounded square on the image.
     *
     * @param  int  $x
     * @param  int  $y
     * @param  int  $w
     * @param  int  $rx
     * @param  ?int $ry
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function roundedSquare(int $x, int $y, int $w, int $rx = 10, ?int $ry = null): Imagick
    {
        return $this->roundedRectangle($x, $y, $w, $w, $rx, $ry);
    }

    /**
     * Draw an ellipse on the image.
     *
     * @param  int  $x
     * @param  int  $y
     * @param  int  $w
     * @param  ?int $h
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function ellipse(int $x, int $y, int $w, ?int $h = null): Imagick
    {
        if ($this->hasImage()) {
            $wid = $w;
            $hgt = ($h === null) ? $w : $h;

            $draw = new \ImagickDraw();

            if ($this->fillColor !== null) {
                $draw->setFillColor($this->image->createColor($this->fillColor, $this->opacity));
            }

            if ($this->strokeWidth > 0) {
                $draw->setStrokeColor($this->image->createColor($this->strokeColor, $this->opacity));
                $draw->setStrokeWidth($this->strokeWidth);
            }

            $draw->ellipse($x, $y, $wid, $hgt, 0, 360);
            $this->image->getResource()->drawImage($draw);
        }

        return $this;
    }

    /**
     * Method to add a circle to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function circle(int $x, int $y, int $w): Imagick
    {
        return $this->ellipse($x, $y, $w, $w);
    }

    /**
     * Draw an arc on the image.
     *
     * @param  int  $x
     * @param  int  $y
     * @param  int  $start
     * @param  int  $end
     * @param  int  $w
     * @param  ?int $h
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function arc(int $x, int $y, int $start, int $end, int $w, ?int $h = null): Imagick
    {
        if ($this->hasImage()) {
            if ($this->strokeWidth == 0) {
                $this->setStrokeWidth(1);
            }

            $wid = $w;
            $hgt = ($h === null) ? $w : $h;

            $draw = new \ImagickDraw();
            $draw->setFillOpacity(0);
            $draw->setStrokeColor($this->image->createColor($this->strokeColor, $this->opacity));
            $draw->setStrokeWidth($this->strokeWidth);

            $draw->ellipse($x, $y, $wid, $hgt, $start, $end);

            $this->image->getResource()->drawImage($draw);
        }

        return $this;
    }

    /**
     * Draw a chord on the image.
     *
     * @param  int  $x
     * @param  int  $y
     * @param  int  $start
     * @param  int  $end
     * @param  int  $w
     * @param  ?int $h
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function chord(int $x, int $y, int $start, int $end, int $w, ?int $h = null): Imagick
    {
        if ($this->hasImage()) {
            $wid = $w;
            $hgt = ($h === null) ? $w : $h;

            $draw = new \ImagickDraw();
            $draw->setFillColor($this->image->createColor($this->fillColor));

            $x1 = $w * cos($start / 180 * pi());
            $y1 = $h * sin($start / 180 * pi());
            $x2 = $w * cos($end / 180 * pi());
            $y2 = $h * sin($end / 180 * pi());

            $draw->ellipse($x, $y, $wid, $hgt, $start, $end);
            $this->image->getResource()->drawImage($draw);

            if ($this->strokeWidth > 0) {
                $draw = new \ImagickDraw();

                $draw->setFillColor($this->image->createColor($this->fillColor));
                $draw->setStrokeColor($this->image->createColor($this->strokeColor));
                $draw->setStrokeWidth($this->strokeWidth);

                $draw->ellipse($x, $y, $wid, $hgt, $start, $end);
                $draw->line($x + $x1, $y + $y1, $x + $x2, $y + $y2);

                $this->image->getResource()->drawImage($draw);
            }
        }

        return $this;
    }

    /**
     * Draw a pie slice on the image.
     *
     * @param  int  $x
     * @param  int  $y
     * @param  int  $start
     * @param  int  $end
     * @param  int  $w
     * @param  ?int $h
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function pie(int $x, int $y, int $start, int $end, int $w, ?int $h = null): Imagick
    {
        if ($this->hasImage()) {
            $wid = $w;
            $hgt = ($h === null) ? $w : $h;

            $draw = new \ImagickDraw();
            $draw->setFillColor($this->image->createColor($this->fillColor));

            $x1 = $w * cos($start / 180 * pi());
            $y1 = $h * sin($start / 180 * pi());
            $x2 = $w * cos($end / 180 * pi());
            $y2 = $h * sin($end / 180 * pi());

            $points = [
                ['x' => $x, 'y' => $y],
                ['x' => $x + $x1, 'y' => $y + $y1],
                ['x' => $x + $x2, 'y' => $y + $y2]
            ];

            $draw->polygon($points);

            $draw->ellipse($x, $y, $wid, $hgt, $start, $end);
            $this->image->getResource()->drawImage($draw);

            if ($this->strokeWidth > 0) {
                $draw = new \ImagickDraw();

                $draw->setFillColor($this->image->createColor($this->fillColor));
                $draw->setStrokeColor($this->image->createColor($this->strokeColor));
                $draw->setStrokeWidth($this->strokeWidth);

                $draw->ellipse($x, $y, $wid, $hgt, $start, $end);
                $draw->line($x, $y, $x + $x1, $y + $y1);
                $draw->line($x, $y, $x + $x2, $y + $y2);

                $this->image->getResource()->drawImage($draw);
            }
        }

        return $this;
    }

    /**
     * Draw a polygon on the image.
     *
     * @param  array $points
     * @throws ImagickDrawException
     * @return Imagick
     */
    public function polygon(array $points): Imagick
    {
        if ($this->hasImage()) {
            $draw = new \ImagickDraw();
            if ($this->fillColor !== null) {
                $draw->setFillColor($this->image->createColor($this->fillColor, $this->opacity));
            }

            if ($this->strokeWidth > 0) {
                $draw->setStrokeColor($this->image->createColor($this->strokeColor, $this->opacity));
                $draw->setStrokeWidth($this->strokeWidth);
            }

            $draw->polygon($points);
            $this->image->getResource()->drawImage($draw);
        }

        return $this;
    }

}
