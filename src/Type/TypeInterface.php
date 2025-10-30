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
namespace Pop\Image\Type;


use Pop\Color\Color;

/**
 * Type interface
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2026 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.3
 */
interface TypeInterface
{

    /**
     * Get the opacity
     *
     * @return int|float|null
     */
    public function getOpacity(): int|float|null;

    /**
     * Get fill color
     *
     * @return Color\ColorInterface
     */
    public function getFillColor(): Color\ColorInterface;

    /**
     * Get stroke color
     *
     * @return Color\ColorInterface
     */
    public function getStrokeColor(): Color\ColorInterface;

    /**
     * Get stroke width
     *
     * @return int
     */
    public function getStrokeWidth(): int;

    /**
     * Set fill color
     *
     * @param  Color\ColorInterface $color
     * @return TypeInterface
     */
    public function setFillColor(Color\ColorInterface $color): TypeInterface;

    /**
     * Set stroke color
     *
     * @param  Color\ColorInterface $color
     * @return TypeInterface
     */
    public function setStrokeColor(Color\ColorInterface $color): TypeInterface;

    /**
     * Set stroke width
     *
     * @param  int $w
     * @return TypeInterface
     */
    public function setStrokeWidth(int $w): TypeInterface;

    /**
     * Set the font size
     *
     * @param  int $size
     * @return TypeInterface
     */
    public function size(int $size): TypeInterface;

    /**
     * Set the font
     *
     * @param  string $font
     * @return TypeInterface
     */
    public function font(string $font): TypeInterface;

    /**
     * Set the X-position
     *
     * @param  int $x
     * @return TypeInterface
     */
    public function x(int $x): TypeInterface;

    /**
     * Set the Y-position
     *
     * @param  int $y
     * @return TypeInterface
     */
    public function y(int $y): TypeInterface;

    /**
     * Set both the X- and Y-positions
     *
     * @param  int $x
     * @param  int $y
     * @return TypeInterface
     */
    public function xy(int $x, int $y): TypeInterface;

    /**
     * Set the rotation of the text
     *
     * @param  int $degrees
     * @return TypeInterface
     */
    public function rotate(int $degrees): TypeInterface;

    /**
     * Set the opacity
     *
     * @param  int|float $opacity
     * @return TypeInterface
     */
    public function setOpacity(int|float $opacity): TypeInterface;
    
}
