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
}
