<?php
namespace Estimators;

/**
 * Фильтруем действия, которые приведут к самоуничтожению - т.е. наезду на свой хвост.
 * Class Suicide
 * @package Estimators
 */
class SuicidePossibilityEstimator extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        $nextPosition = $this->getNextPosition($direction, $hero->position);
        if (isPositionInMap($nextPosition, $hero->lines)) {
            return -1;
        }

        return $weight;
    }

}
