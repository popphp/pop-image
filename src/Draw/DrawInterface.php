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
namespace Pop\Image\Draw;

use Pop\Image\Color;

/**
 * Draw interface
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
interface DrawInterface
{

    /**
     * Set the opacity
     *
     * @param  float $opacity
     * @return DrawInterface
     */
    public function setOpacity($opacity);

    /**
     * Get the opacity
     *
     * @return mixed
     */
    public function getOpacity();

    /**
     * Get fill color
     *
     * @return Color\Colorinterface
     */
    public function getFillColor();

    /**
     * Get stroke color
     *
     * @return Color\Colorinterface
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
     * @return DrawInterface
     */
    public function setFillColor(Color\ColorInterface $color);

    /**
     * Set stroke color
     *
     * @param  Color\ColorInterface $color
     * @return DrawInterface
     */
    public function setStrokeColor(Color\ColorInterface $color);

    /**
     * Get stroke width
     *
     * @param int $w
     * @return DrawInterface
     */
    public function setStrokeWidth($w);

}
