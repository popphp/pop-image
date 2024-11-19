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
namespace Pop\Image;

use Pop\Image\Adapter\AbstractAdapter;

/**
 * Abstract image edit class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2025 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    4.1.0
 */
abstract class AbstractEditObject
{

    /**
     * Image object
     * @var mixed
     */
    protected mixed $image = null;

    /**
     * Constructor
     *
     * Instantiate an image edit object
     *
     * @param ?AbstractAdapter $image
     */
    public function __construct(?AbstractAdapter $image = null)
    {
        if ($image !== null) {
            $this->setImage($image);
        }
    }

    /**
     * Get the image object
     *
     * @return AbstractAdapter|null
     */
    public function getImage(): AbstractAdapter|null
    {
        return $this->image;
    }

    /**
     * Set the image object
     *
     * @param  AbstractAdapter $image
     * @return AbstractEditObject
     */
    public function setImage(AbstractAdapter $image): AbstractEditObject
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Has the image object
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return ($this->image !== null);
    }

}
