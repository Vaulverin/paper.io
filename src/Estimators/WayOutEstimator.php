<?php


namespace Estimators;


use Helpers\BFSCached;
use Helpers\BreadthFirstSearch;

/**
 * После любого действия должна оставаться возможность вернуться на свою территорию.
 * Class WayOut
 * @package Estimators
 */
class WayOutEstimator extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        $nextPosition = $this->getNextPosition($direction, $hero->position);
        $bfs = new BreadthFirstSearch($this->settings->width, $this->settings->xCount);
        $bfs = new BFSCached($bfs);
        if (!$bfs->isReachable($nextPosition, $hero->territory, $hero->lines)) {
            return -1;
        }

        return $weight;
    }




}
