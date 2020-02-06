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
namespace Pop\Image\Effect;

use Pop\Image\Color;

/**
 * Effect interface
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2020 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.4.0
 */
interface EffectInterface
{


    /**
     * Get the blend between 2 colors
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @param  int                  $tween
     * @return array
     */
    public function getBlend(Color\ColorInterface $color1, Color\ColorInterface $color2, $tween);

    /**
     * Calculate the steps between two points
     *
     * @param  int $curStep
     * @param  int $start
     * @param  int $end
     * @param  int $totalSteps
     * @return int
     */
    public function calculateSteps($curStep, $start, $end, $totalSteps);

}
