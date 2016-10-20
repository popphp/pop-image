<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Effect;

use Pop\Image\AbstractEditObject;
use Pop\Image\Color;

/**
 * Abstract effect class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
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
    protected function getBlend(Color\ColorInterface $color1, Color\ColorInterface $color2, $tween)
    {
        if (($color1 instanceof Color\Rgb) && ($color2 instanceof Color\Rgb)) {
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
                $blend['r'][] = round($this->calculateSteps($i, $r1, $rTotal, $tween));
                $blend['g'][] = round($this->calculateSteps($i, $g1, $gTotal, $tween));
                $blend['b'][] = round($this->calculateSteps($i, $b1, $bTotal, $tween));
            }
        } else if (($color1 instanceof Color\Cmyk) && ($color2 instanceof Color\Cmyk)) {
            $blend = ['c' => [], 'm' => [], 'y' => [], 'k' => []];

            $c1 = $color1->getC();
            $m1 = $color1->getM();
            $y1 = $color1->getY();
            $k1 = $color1->getK();

            $c2 = $color2->getC();
            $m2 = $color2->getM();
            $y2 = $color2->getY();
            $k2 = $color2->getK();

            $cTotal = $c2 - $c1;
            $mTotal = $m2 - $m1;
            $yTotal = $y2 - $y1;
            $kTotal = $k2 - $k1;

            for ($i = 0; $i <= $tween; $i++) {
                $blend['c'][] = round($this->calculateSteps($i, $c1, $cTotal, $tween));
                $blend['m'][] = round($this->calculateSteps($i, $m1, $mTotal, $tween));
                $blend['y'][] = round($this->calculateSteps($i, $y1, $yTotal, $tween));
                $blend['k'][] = round($this->calculateSteps($i, $k1, $kTotal, $tween));
            }
        } else if (($color1 instanceof Color\Gray) && ($color2 instanceof Color\Gray)) {
            $blend = ['g' => []];

            $g1 = $color1->getGray();
            $g2 = $color2->getGray();

            $gTotal = $g2 - $g1;

            for ($i = 0; $i <= $tween; $i++) {
                $blend['g'][] = round($this->calculateSteps($i, $g1, $gTotal, $tween));
            }
        } else {
            throw new Exception('Error: The two colors passed must be of the same type');
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
     * @return int
     */
    protected function calculateSteps($curStep, $start, $end, $totalSteps)
    {
        return ($end * ($curStep / $totalSteps)) + $start;
    }

}
