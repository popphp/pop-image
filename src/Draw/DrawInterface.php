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

use Pop\Color\Color;

/**
 * Draw interface
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.0
 */
interface DrawInterface
{

    /**
     * Set the opacity
     *
     * @param  int|float $opacity
     * @return DrawInterface
     */
    public function setOpacity(int|float $opacity): DrawInterface;

    /**
     * Get the opacity
     *
     * @return mixed
     */
    public function getOpacity(): mixed;

    /**
     * Get fill color
     *
     * @return Color\Colorinterface
     */
    public function getFillColor(): Color\Colorinterface;

    /**
     * Get stroke color
     *
     * @return Color\Colorinterface
     */
    public function getStrokeColor(): Color\Colorinterface;

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
     * @return DrawInterface
     */
    public function setFillColor(Color\ColorInterface $color): DrawInterface;

    /**
     * Set stroke color
     *
     * @param  Color\ColorInterface $color
     * @return DrawInterface
     */
    public function setStrokeColor(Color\ColorInterface $color): DrawInterface;

    /**
     * Get stroke width
     *
     * @param int $w
     * @return DrawInterface
     */
    public function setStrokeWidth(int $w): DrawInterface;

}
