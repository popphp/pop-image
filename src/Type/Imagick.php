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

/**
 * Type class for Imagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.2
 */
class Imagick extends AbstractType
{

    /**
     * Opacity
     * @var float
     */
    protected $opacity = 1.0;

    /**
     * Set the opacity
     *
     * @param  float $opacity
     * @return Imagick
     */
    public function setOpacity($opacity)
    {
        $this->opacity = $opacity;
        return $this;
    }

    /**
     * Set and apply the text on the image
     *
     * @param  string $string
     * @throws Exception
     * @return Imagick
     */
    public function text($string)
    {
        if ($this->hasImage()) {
            $draw = new \ImagickDraw();

            // Set the font if passed
            if (null !== $this->font) {
                if (!$draw->setFont($this->font)) {
                    throw new Exception("Error: The font '" . $this->font . "' is not recognized by the Gmagick extension.");
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

            if (null !== $this->rotation) {
                $draw->rotate($this->rotation);
            }

            if (null !== $this->strokeColor) {
                $draw->setStrokeColor($this->image->createColor($this->strokeColor, $this->opacity));
                $draw->setStrokeWidth((int)$this->strokeWidth);
            }

            $draw->annotation($this->x, $this->y, $string);
            $this->image->getResource()->drawImage($draw);
        }

        return $this;
    }

}
