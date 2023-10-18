<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Type;

use Pop\Image\AbstractEditObject;
use Pop\Color\Color;

/**
 * Type abstract class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    4.0.0
 */
abstract class AbstractType extends AbstractEditObject implements TypeInterface
{

    /**
     * Type font size
     * @var int
     */
    protected int $size = 12;

    /**
     * Type font
     * @var ?string
     */
    protected ?string $font = null;

    /**
     * Fill color
     * @var ?Color\ColorInterface
     */
    protected ?Color\ColorInterface $fillColor = null;

    /**
     * Stroke color
     * @var ?Color\ColorInterface
     */
    protected ?Color\ColorInterface $strokeColor = null;

    /**
     * Stroke width
     * @var int
     */
    protected int $strokeWidth = 1;

    /**
     * Type X-position
     * @var int
     */
    protected int $x = 0;

    /**
     * Type Y-position
     * @var int
     */
    protected int $y = 0;

    /**
     * Type rotation in degrees
     * @var int
     */
    protected int $rotation = 0;

    /**
     * Opacity
     * @var int|float|null
     */
    protected int|float|null $opacity = null;

    /**
     * Get the opacity
     *
     * @return int|float|null
     */
    public function getOpacity(): int|float|null
    {
        return $this->opacity;
    }

    /**
     * Get fill color
     *
     * @return Color\ColorInterface
     */
    public function getFillColor(): Color\ColorInterface
    {
        return $this->fillColor;
    }

    /**
     * Get stroke color
     *
     * @return Color\ColorInterface
     */
    public function getStrokeColor(): Color\ColorInterface
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
     * @return AbstractType
     */
    public function setFillColor(Color\ColorInterface $color): AbstractType
    {
        $this->fillColor = $color;
        return $this;
    }

    /**
     * Set stroke color
     *
     * @param  Color\ColorInterface $color
     * @return AbstractType
     */
    public function setStrokeColor(Color\ColorInterface $color): AbstractType
    {
        $this->strokeColor = $color;
        return $this;
    }

    /**
     * Set stroke width
     *
     * @param  int $w
     * @return AbstractType
     */
    public function setStrokeWidth(int $w): AbstractType
    {
        $this->strokeWidth = $w;
        return $this;
    }

    /**
     * Set the font size
     *
     * @param  int $size
     * @return AbstractType
     */
    public function size(int $size): AbstractType
    {
        $this->size = (int)$size;
        return $this;
    }

    /**
     * Set the font
     *
     * @param  string $font
     * @return AbstractType
     */
    public function font(string $font): AbstractType
    {
        $this->font = $font;
        return $this;
    }

    /**
     * Set the X-position
     *
     * @param  int $x
     * @return AbstractType
     */
    public function x(int $x): AbstractType
    {
        $this->x = (int)$x;
        return $this;
    }

    /**
     * Set the Y-position
     *
     * @param  int $y
     * @return AbstractType
     */
    public function y(int $y): AbstractType
    {
        $this->y = (int)$y;
        return $this;
    }

    /**
     * Set both the X- and Y-positions
     *
     * @param  int $x
     * @param  int $y
     * @return AbstractType
     */
    public function xy(int $x, int $y): AbstractType
    {
        $this->x($x);
        $this->y($y);
        return $this;
    }

    /**
     * Set the rotation of the text
     *
     * @param  int $degrees
     * @return AbstractType
     */
    public function rotate(int $degrees): AbstractType
    {
        $this->rotation = (int)$degrees;
        return $this;
    }

    /**
     * Set the opacity
     *
     * @param  int|float $opacity
     * @return AbstractType
     */
    abstract public function setOpacity(int|float$opacity): AbstractType;

}
