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
namespace Pop\Image\Filter;

/**
 * Abstract filter class
 *
 * @category   Pop
 * @package    Pop_Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.0
 */
abstract class AbstractFilter implements FilterInterface
{

    /**
     * Image object
     * @var \Pop\Image\AbstractImage
     */
    protected $image = null;

    /**
     * Constructor
     *
     * Instantiate an image object
     *
     * @param  \Pop\Image\AbstractImage $image
     * @return AbstractFilter
     */
    public function __construct(\Pop\Image\AbstractImage $image = null)
    {
        if (null !== $image) {
            $this->setImage($image);
        }
    }

    /**
     * Get the image object
     *
     * @return \Pop\Image\AbstractImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the image object
     *
     * @param  \Pop\Image\AbstractImage $image
     * @return AbstractFilter
     */
    public function setImage(\Pop\Image\AbstractImage $image)
    {
        $this->image = $image;
        return $this;
    }

}
