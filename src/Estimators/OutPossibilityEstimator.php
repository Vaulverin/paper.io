<?php
namespace Estimators;

/**
 * Фильтруем действия, которые приведут к выходу за границы карты.
 * Class Edge
 * @package Estimators
 */
class OutPossibilityEstimator extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        $nextPosition = $this->getNextPosition($direction, $hero->position);
        $maxValue = $this->settings->width * $this->settings->xCount;
        foreach ($nextPosition as $value) {
            if ($value < 0 || $value > $maxValue) {
                return -1;
            }
        }

        return $weight;
    }
}
