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

use Pop\Image\AbstractEditObject;
use Pop\Color\Color;

/**
 * Draw abstract class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.1
 */
abstract class AbstractDraw extends AbstractEditObject implements DrawInterface
{

    /**
     * Opacity
     * @var int|float|null
     */
    protected int|float|null $opacity = null;

    /**
     * Fill color
     * @var ?Color\Colorinterface
     */
    protected ?Color\Colorinterface $fillColor = null;

    /**
     * Stroke color
     * @var ?Color\Colorinterface
     */
    protected ?Color\Colorinterface$strokeColor = null;

    /**
     * Stroke width
     * @var int
     */
    protected int $strokeWidth = 0;

    /**
     * Set the opacity
     *
     * @param  int|float $opacity
     * @return AbstractDraw
     */
    abstract public function setOpacity(int|float $opacity): AbstractDraw;

    /**
     * Get the opacity
     *
     * @return mixed
     */
    public function getOpacity(): mixed
    {
        return $this->opacity;
    }

    /**
     * Get fill color
     *
     * @return Color\Colorinterface
     */
    public function getFillColor(): Color\Colorinterface
    {
        return $this->fillColor;
    }

    /**
     * Get stroke color
     *
     * @return Color\Colorinterface
     */
    public function getStrokeColor(): Color\Colorinterface
    {
        return $this->strokeColor;
    }

    /**
     * Get stroke width
     *
     * @return int
     */
    public function getStrokeWidth(): int
    {
        return $this->strokeWidth;
    }

    /**
     * Set fill color
     *
     * @param  Color\ColorInterface $color
     * @return AbstractDraw
     */
    public function setFillColor(Color\ColorInterface $color): AbstractDraw
    {
        $this->fillColor = $color;
        return $this;
    }

    /**
     * Set stroke color
     *
     * @param  Color\ColorInterface $color
     * @return AbstractDraw
     */
    public function setStrokeColor(Color\ColorInterface $color): AbstractDraw
    {
        $this->strokeColor = $color;
        return $this;
    }

    /**
     * Get stroke width
     *
     * @param int $w
     * @return AbstractDraw
     */
    public function setStrokeWidth(int $w): AbstractDraw
    {
        $this->strokeWidth = $w;
        return $this;
    }

}
