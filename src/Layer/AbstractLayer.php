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
namespace Pop\Image\Layer;

use Pop\Image\AbstractEditObject;

/**
 * Layer abstract class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.0
 */
abstract class AbstractLayer extends AbstractEditObject implements LayerInterface
{

    /**
     * Opacity
     * @var mixed
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
     * Set the image opacity.
     *
     * @param  int|float $opacity
     * @return AbstractLayer
     */
    public function setOpacity(int|float $opacity): AbstractLayer
    {
        $this->opacity = $opacity;
        return $this;
    }

}
