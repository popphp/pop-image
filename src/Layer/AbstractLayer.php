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
namespace Pop\Image\Layer;

use Pop\Image\AbstractEditObject;

/**
 * Layer abstract class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
abstract class AbstractLayer extends AbstractEditObject implements LayerInterface
{

    /**
     * Opacity
     * @var mixed
     */
    protected $opacity = null;

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
     * Set the image opacity.
     *
     * @param  int|float $opacity
     * @return AbstractLayer
     */
    public function setOpacity($opacity)
    {
        $this->opacity = $opacity;
        return $this;
    }

}
