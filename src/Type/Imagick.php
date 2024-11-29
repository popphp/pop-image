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
namespace Pop\Image\Type;

use ImagickException;
use ImagickDrawException;

/**
 * Type class for Imagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.1
 */
class Imagick extends AbstractType
{

    /**
     * Opacity
     * @var int|float|null
     */
    protected int|float|null $opacity = 1.0;

    /**
     * Set the opacity
     *
     * @param  int|float $opacity
     * @return Imagick
     */
    public function setOpacity(int|float $opacity): Imagick
    {
        $this->opacity = $opacity;
        return $this;
    }

    /**
     * Set and apply the text on the image
     *
     * @param string $string
     * @throws Exception|ImagickException|ImagickDrawException
     * @return Imagick
     */
    public function text(string $string): Imagick
    {
        if ($this->hasImage()) {
            $draw = new \ImagickDraw();

            // Set the font if passed
            if ($this->font !== null) {
                if (!$draw->setFont($this->font)) {
                    throw new Exception("Error: The font '" . $this->font . "' is not recognized by the Imagick extension.");
                }
                // Else, attempt to set a basic, default system font
            } else {
                $fonts = $this->image->getResource()->queryFonts();
                if (in_array('Arial', $fonts)) {
                    $this->font = 'Arial';
                } else if (in_array('Helvetica', $fonts)) {
                    $this->font = 'Helvetica';
                } else if (in_array('Tahoma', $fonts)) {
                    $this->font = 'Tahoma';
                } else if (in_array('Verdana', $fonts)) {
                    $this->font = 'Verdana';
                } else if (in_array('System', $fonts)) {
                    $this->font = 'System';
                } else if (in_array('Fixed', $fonts)) {
                    $this->font = 'Fixed';
                } else if (in_array('system', $fonts)) {
                    $this->font = 'system';
                } else if (in_array('fixed', $fonts)) {
                    $this->font = 'fixed';
                } else if (isset($fonts[0])) {
                    $this->font = $fonts[0];
                } else {
                    throw new Exception('Error: No default font could be found by the Imagick extension.');
                }
            }

            $draw->setFont($this->font);
            $draw->setFontSize($this->size);
            $draw->setFillColor($this->image->createColor($this->fillColor, $this->opacity));

            if ($this->rotation !== null) {
                $draw->rotate($this->rotation);
            }

            if ($this->strokeColor !== null) {
                $draw->setStrokeColor($this->image->createColor($this->strokeColor, $this->opacity));
                $draw->setStrokeWidth((int)$this->strokeWidth);
            }

            $draw->annotation($this->x, $this->y, $string);
            $this->image->getResource()->drawImage($draw);
        }

        return $this;
    }

}
