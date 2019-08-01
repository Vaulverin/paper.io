<?php
namespace Estimators;


class Suicide extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        $nextPosition = $this->getNextPosition($direction, $hero->position);
        if ($this->isPositionInMap($nextPosition, $hero->lines)) {
            return -1;
        }

        return $weight;
    }

    function isPositionInMap($position, $map)
    {
        foreach ($map as $mapPosition) {
            if ($position[0] == $mapPosition[0] && $position[1] == $mapPosition[1]) {
                return true;
            }
        }

        return false;
    }

}
