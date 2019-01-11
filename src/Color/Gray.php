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
namespace Pop\Image\Color;

/**
 * Image gray color class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2019 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.0
 */
class Gray extends AbstractColor
{

    /**
     * Gray
     * @var float
     */
    protected $gray = 0;

    /**
     * Constructor
     *
     * Instantiate a PDF Gray Color object
     *
     * @param  mixed $gray   0 - 100
     */
    public function __construct($gray)
    {
        $this->setGray($gray);
    }

    /**
     * Set the gray value
     *
     * @param  mixed $gray
     * @throws \OutOfRangeException
     * @return Gray
     */
    public function setGray($gray)
    {
        if (((int)$gray < 0) || ((int)$gray > 100)) {
            throw new \OutOfRangeException('Error: The value must be between 0 and 100');
        }
        $this->gray = (int)$gray;
        return $this;
    }

    /**
     * Get the gray value
     *
     * @return float
     */
    public function getGray()
    {
        return $this->gray;
    }

    /**
     * Convert to CMYK
     *
     * @return Cmyk
     */
    public function toCmyk()
    {
        return new Cmyk(0, 0, 0, $this->gray);
    }

    /**
     * Convert to RGB
     *
     * @return Rgb
     */
    public function toRgb()
    {
        return new Rgb($this->gray, $this->gray, $this->gray);
    }

    /**
     * Method to print the color object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->gray;
    }

}