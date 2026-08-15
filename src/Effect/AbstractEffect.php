<?php
declare(strict_types=1);
/**
 * Pop PHP Framework (https://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2027 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Effect;

use Pop\Image\AbstractEditObject;
use Pop\Color\Color;

/**
 * Abstract effect class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@noladev.com>
 * @copyright  Copyright (c) 2009-2027 NOLA Interactive, LLC.
 * @license    https://www.popphp.org/license     New BSD License
 * @version    5.0.0
 */
abstract class AbstractEffect extends AbstractEditObject implements EffectInterface
{

    /**
     * Get the blend between 2 colors
     *
     * @param  Color\ColorInterface $color1
     * @param  Color\ColorInterface $color2
     * @param  int                  $tween
     * @throws Exception
     * @return array
     */
    public function getBlend(Color\ColorInterface $color1, Color\ColorInterface $color2, int $tween): array
    {
        if (!($color1 instanceof Color\Rgb)) {
            if (!method_exists($color1, 'toRgb')) {
                throw new Exception('Error: The color object does not support conversion to RGB.');
            }
            $color1 = $color1->toRgb();
        }
        if (!($color2 instanceof Color\Rgb)) {
            if (!method_exists($color2, 'toRgb')) {
                throw new Exception('Error: The color object does not support conversion to RGB.');
            }
            $color2 = $color2->toRgb();
        }

        $blend = ['r' => [], 'g' => [], 'b' => []];

        $r1 = $color1->getR();
        $g1 = $color1->getG();
        $b1 = $color1->getB();

        $r2 = $color2->getR();
        $g2 = $color2->getG();
        $b2 = $color2->getB();

        $rTotal = $r2 - $r1;
        $gTotal = $g2 - $g1;
        $bTotal = $b2 - $b1;

        for ($i = 0; $i <= $tween; $i++) {
            $blend['r'][] = (int)round($this->calculateSteps($i, $r1, $rTotal, $tween));
            $blend['g'][] = (int)round($this->calculateSteps($i, $g1, $gTotal, $tween));
            $blend['b'][] = (int)round($this->calculateSteps($i, $b1, $bTotal, $tween));
        }

        return $blend;
    }

    /**
     * Calculate the steps between two points
     *
     * @param  int $curStep
     * @param  int $start
     * @param  int $end
     * @param  int $totalSteps
     * @return int|float
     */
    public function calculateSteps(int $curStep, int $start, int $end, int $totalSteps): int|float
    {
        return ($end * ($curStep / $totalSteps)) + $start;
    }

}
