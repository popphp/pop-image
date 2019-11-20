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

use Pop\Image\AbstractEditObject;
use Pop\Image\Color;

/**
 * Draw abstract class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
abstract class AbstractDraw extends AbstractEditObject implements DrawInterface
{

    /**
     * Opacity
     * @var mixed
     */
    protected $opacity = null;

    /**
     * Fill color
     * @var Color\Colorinterface
     */
    protected $fillColor = null;

    /**
     * Stroke color
     * @var Color\Colorinterface
     */
    protected $strokeColor = null;

    /**
     * Stroke width
     * @var int
     */
    protected $strokeWidth = 0;

    /**
     * Set the opacity
     *
     * @param  float $opacity
     * @return AbstractDraw
     */
    abstract public function setOpacity($opacity);

    /**
     * Get the opacity
     *
     * @return mixed
     */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
     * Get fill color
     *
     * @return Color\Colorinterface
     */
    public function getFillColor()
    {
        return $this->fillColor;
    }

    /**
     * Get stroke color
     *
     * @return Color\Colorinterface
     */
    public function getStrokeColor()
    {
        return $this->strokeColor;
    }

    /**
     * Get stroke width
     *
     * @return int
     */
    public function getStrokeWidth()
    {
        return $this->strokeWidth;
    }

    /**
     * Set fill color
     *
     * @param  Color\ColorInterface $color
     * @return AbstractDraw
     */
    public function setFillColor(Color\ColorInterface $color)
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
    public function setStrokeColor(Color\ColorInterface $color)
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
    public function setStrokeWidth($w)
    {
        $this->strokeWidth = (int)$w;
        return $this;
    }

}
