<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Layer;

/**
 * Layer class for Gd
 *
 * @category   Pop
 * @package    Pop_Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.0
 */
class Gd extends AbstractLayer
{

    /**
     * Opacity
     * @var int
     */
    protected $opacity = 100;

    /**
     * Overlay an image onto the current image.
     *
     * @param  string $image
     * @param  int    $x
     * @param  int    $y
     * @throws Exception
     * @return Gd
     */
    public function overlay($image, $x = 0, $y = 0)
    {
        imagealphablending($this->image->resource(), true);

        // Create an image resource from the overlay image.
        if (stripos($image, '.gif') !== false) {
            $overlay = imagecreatefromgif($image);
        } else if (stripos($image, '.png') !== false) {
            $overlay = imagecreatefrompng($image);
        } else if (stripos($image, '.jp') !== false) {
            $overlay = imagecreatefromjpeg($image);
        } else {
            throw new Exception('Error: The overlay image must be either a JPG, GIF or PNG.');
        }

        if ($this->opacity > 0) {
            if ($this->opacity == 100) {
                imagecopy($this->image->resource(), $overlay, $x, $y, 0, 0, imagesx($overlay), imagesy($overlay));
            } else{
                imagecopymerge($this->image->resource(), $overlay, $x, $y, 0, 0, imagesx($overlay), imagesy($overlay), $this->opacity);
            }
        }

        return $this;
    }

}
