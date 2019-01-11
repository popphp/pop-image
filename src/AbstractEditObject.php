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
namespace Pop\Image;

use Pop\Image\Adapter\AbstractAdapter;

/**
 * Abstract image edit class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2019 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.3.0
 */
abstract class AbstractEditObject
{

    /**
     * Image object
     * @var mixed
     */
    protected $image = null;

    /**
     * Constructor
     *
     * Instantiate an image edit object
     *
     * @param AbstractAdapter $image
     */
    public function __construct(AbstractAdapter $image = null)
    {
        if (null !== $image) {
            $this->setImage($image);
        }
    }

    /**
     * Get the image object
     *
     * @return AbstractAdapter
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the image object
     *
     * @param  AbstractAdapter $image
     * @return AbstractEditObject
     */
    public function setImage(AbstractAdapter $image)
    {
        $this->image = $image;
        return $this;
    }

}
