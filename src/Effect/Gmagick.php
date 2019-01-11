<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2019 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Effect;

use Pop\Image\Color;

/**
 * Effect class for Gmagick
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2019 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.0
 */
class Gmagick extends AbstractEffect
{

    /**
     * Draw a border around the image.
     *
     * @param  Color\ColorInterface $color
     * @param  int                  $w
     * @param  int                  $h
     * @throws Exception
     * @return Gmagick
     */
    public function border(Color\ColorInterface $color, $w = 1, $h = null)
    {
        $h = (null === $h) ? $w : $h;
        $this->image->getResource()->borderImage($this->image->createColor($color), $w, $h);
        return $this;
    }

    /**
     * Flood the image with a color fill.
     *
     * @param  Color\ColorInterface $color
     * @return Gmagick
     */
    public function fill(Color\ColorInterface $color)
    {
        $draw = new \GmagickDraw();
        $draw->setfillcolor($this->image->createColor($color));
        $draw->rectangle(0, 0, $this->image->getWidth(), $this->image->getHeight());
        $this->image->getResource()->drawImage($draw);
        return $this;
    }

}
