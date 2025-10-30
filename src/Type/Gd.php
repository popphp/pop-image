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

/**
 * Type class for Gd
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2026 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.3
 */
class Gd extends AbstractType
{

    /**
     * Opacity
     * @var int|float|null
     */
    protected int|float|null $opacity = 0;

    /**
     * Set the opacity
     *
     * @param  int|float $opacity
     * @return Gd
     */
    public function setOpacity(int|float $opacity): Gd
    {
        $this->opacity = (int)round((127 - (127 * ($opacity / 100))));
        return $this;
    }

    /**
     * Set and apply the text on the image
     *
     * @param  string $string
     * @return Gd
     */
    public function text(string $string): Gd
    {
        if ($this->hasImage()) {
            $fillColor = ($this->image->isIndexed()) ? $this->image->createColor($this->fillColor, null) :
                $this->image->createColor($this->fillColor, $this->opacity);

            if (($this->font !== null) && function_exists('imagettftext')) {
                if ($this->strokeColor !== null) {
                    $strokeColor = ($this->image->isIndexed()) ? $this->image->createColor($this->strokeColor, null) :
                        $this->image->createColor($this->strokeColor, $this->opacity);
                    imagettftext($this->image->getResource(), $this->size, $this->rotation, $this->x, ($this->y - 1), $strokeColor, $this->font, $string);
                    imagettftext($this->image->getResource(), $this->size, $this->rotation, $this->x, ($this->y + 1), $strokeColor, $this->font, $string);
                    imagettftext($this->image->getResource(), $this->size, $this->rotation, ($this->x - 1), $this->y, $strokeColor, $this->font, $string);
                    imagettftext($this->image->getResource(), $this->size, $this->rotation, ($this->x + 1), $this->y, $strokeColor, $this->font, $string);
                }
                imagettftext($this->image->getResource(), $this->size, $this->rotation, $this->x, $this->y, $fillColor, $this->font, $string);
            } else {
                // Cap the system font size between 1 and 5
                if ($this->size > 5) {
                    $this->size = 5;
                } else if ($this->size < 1) {
                    $this->size = 1;
                }
                imagestring($this->image->getResource(), $this->size, $this->x, $this->y, $string, $fillColor);
            }
        }

        return $this;
    }

}
