<?php


namespace Estimators;


use Helpers\BFSCached;
use Helpers\BreadthFirstSearch;

/**
 * Вычисляем возможную угрозу со стороны соперников.
 * Class TimeOut
 * @package Estimators
 */
class EnemyDangerEstimator extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        if (count($this->tick->enemies) > 0 && count($hero->lines) > 0) {
            $nextPosition = $this->getNextPosition($direction, $hero->position);
            $bfs = new BreadthFirstSearch($this->settings->width, $this->settings->xCount);
            $bfs = new BFSCached($bfs);
            $path = $bfs->getShortestPath($hero->position, $hero->territory, $hero->lines);
            $distance = count($path) / $hero->speed;
            foreach ($this->tick->enemies as $enemy) {
                $enemyPath = $bfs->getShortestPath($enemy->position, $hero->lines, $enemy->lines);
                if ($enemyPath) {
                    $enemyDistance = count($enemyPath) / $enemy->speed - 1;
                    if ($distance >= $enemyDistance) {
                        $firstMove = $path[1];
                        if ($firstMove[0] == $nextPosition[0] && $firstMove[1] == $nextPosition[1]) {
                            return $weight;
                        }

                        return -1;
                    }
                }
            }
        }

        return $weight;
    }
    
}
