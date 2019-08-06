<?php


namespace Estimators;


/**
 * Чем больше территори захватим - тем лучше!
 * Определяем по дистанции от захваченных территорий, если точка дальше всех - она приоритет.
 * Class Greedy
 * @package Estimators
 */
class GreedyWayEstimator extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        $nextPosition = $this->getNextPosition($direction, $hero->position);
        if (count($hero->lines) < 2) {
            $map = $hero->territory;
        } else {
            $map = array_slice($hero->lines, -3);
        }

        foreach ($map as $position) {
            $weight += getDistanceBtwPositions($nextPosition, $position);
        }

        return $weight;
    }

}
