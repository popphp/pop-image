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
namespace Pop\Image\Color;

/**
 * Image RGB color class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
class Rgb extends AbstractColor
{

    /**
     * Red
     * @var float
     */
    protected $r = 0;

    /**
     * Green
     * @var float
     */
    protected $g = 0;

    /**
     * Blue
     * @var float
     */
    protected $b = 0;

    /**
     * Constructor
     *
     * Instantiate a PDF RGB Color object
     *
     * @param  mixed $r   0 - 255
     * @param  mixed $g   0 - 255
     * @param  mixed $b   0 - 255
     */
    public function __construct($r, $g, $b)
    {
        $this->setR($r);
        $this->setG($g);
        $this->setB($b);
    }

    /**
     * Set the red value
     *
     * @param  mixed $r
     * @throws \OutOfRangeException
     * @return Rgb
     */
    public function setR($r)
    {
        if (((int)$r < 0) || ((int)$r > 255)) {
            throw new \OutOfRangeException('Error: The value must be between 0 and 255');
        }
        $this->r = (int)$r;
        return $this;
    }

    /**
     * Set the green value
     *
     * @param  mixed $g
     * @throws \OutOfRangeException
     * @return Rgb
     */
    public function setG($g)
    {
        if (((int)$g < 0) || ((int)$g > 255)) {
            throw new \OutOfRangeException('Error: The value must be between 0 and 255');
        }
        $this->g = (int)$g;
        return $this;
    }

    /**
     * Set the blue value
     *
     * @param  mixed $b
     * @throws \OutOfRangeException
     * @return Rgb
     */
    public function setB($b)
    {
        if (((int)$b < 0) || ((int)$b > 255)) {
            throw new \OutOfRangeException('Error: The value must be between 0 and 255');
        }
        $this->b = (int)$b;
        return $this;
    }

    /**
     * Get the red value
     *
     * @return float
     */
    public function getR()
    {
        return $this->r;
    }

    /**
     * Get the green value
     *
     * @return float
     */
    public function getG()
    {
        return $this->g;
    }

    /**
     * Get the blue value
     *
     * @return float
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * Convert to CMYK
     *
     * @return Cmyk
     */
    public function toCmyk()
    {
        $K = 1;

        // Calculate CMY.
        $cyan    = 1 - ($this->r / 255);
        $magenta = 1 - ($this->g / 255);
        $yellow  = 1 - ($this->b / 255);

        // Calculate K.
        if ($cyan < $K) {
            $K = $cyan;
        }
        if ($magenta < $K) {
            $K = $magenta;
        }
        if ($yellow < $K) {
            $K = $yellow;
        }

        if ($K == 1) {
            $cyan    = 0;
            $magenta = 0;
            $yellow  = 0;
        } else {
            $cyan    = round((($cyan - $K) / (1 - $K)) * 100);
            $magenta = round((($magenta - $K) / (1 - $K)) * 100);
            $yellow  = round((($yellow - $K) / (1 - $K)) * 100);
        }

        $black = round($K * 100);

        return new Cmyk($cyan, $magenta, $yellow, $black);
    }

    /**
     * Convert to Gray
     *
     * @return Gray
     */
    public function toGray()
    {
        return new Gray(floor(($this->r + $this->g + $this->b) / 3));
    }

    /**
     * Convert to hex string
     *
     * @return string
     */
    public function toHex()
    {
        return sprintf('%02x', $this->r) . sprintf('%02x', $this->g) . sprintf('%02x', $this->b);
    }

    /**
     * Method to print the color object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->r . ', ' . $this->g . ', ' . $this->b;
    }

}