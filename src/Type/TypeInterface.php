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
namespace Pop\Image\Type;


use Pop\Image\Color;

/**
 * Type interface
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
interface TypeInterface
{

    /**
     * Get the opacity
     *
     * @return mixed
     */
    public function getOpacity();

    /**
     * Get fill color
     *
     * @return Color\ColorInterface
     */
    public function getFillColor();

    /**
     * Get stroke color
     *
     * @return Color\ColorInterface
     */
    public function getStrokeColor();

    /**
     * Get stroke width
     *
     * @return int
     */
    public function getStrokeWidth();

    /**
     * Set fill color
     *
     * @param  Color\ColorInterface $color
     * @return TypeInterface
     */
    public function setFillColor(Color\ColorInterface $color);

    /**
     * Set stroke color
     *
     * @param  Color\ColorInterface $color
     * @return TypeInterface
     */
    public function setStrokeColor(Color\ColorInterface $color);

    /**
     * Set stroke width
     *
     * @param  int $w
     * @return TypeInterface
     */
    public function setStrokeWidth($w);

    /**
     * Set the font size
     *
     * @param  int $size
     * @return TypeInterface
     */
    public function size($size);

    /**
     * Set the font
     *
     * @param  string $font
     * @return TypeInterface
     */
    public function font($font);

    /**
     * Set the X-position
     *
     * @param  int $x
     * @return TypeInterface
     */
    public function x($x);

    /**
     * Set the Y-position
     *
     * @param  int $y
     * @return TypeInterface
     */
    public function y($y);

    /**
     * Set both the X- and Y-positions
     *
     * @param  int $x
     * @param  int $y
     * @return TypeInterface
     */
    public function xy($x, $y);

    /**
     * Set the rotation of the text
     *
     * @param  int $degrees
     * @return TypeInterface
     */
    public function rotate($degrees);

    /**
     * Set the opacity
     *
     * @param  mixed $opacity
     * @return TypeInterface
     */
    public function setOpacity($opacity);
    
}
