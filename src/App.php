<?php

use Estimators\AbstractEstimator;
use Estimators\OutPossibilityEstimator;
use Estimators\SuicidePossibilityEstimator;
use Estimators\GreedyWayEstimator;
use Estimators\TimeOutEstimator;
use Estimators\EnemyDangerEstimator;
use Estimators\WayOutEstimator;
use Game\Player;
use Game\Settings;
use Game\Tick;
use Helpers\BFSCached;
use const Game\AVAILABLE_DIRECTIONS;

class App
{
    /**
     * @var Settings
     */
    protected $settings;

    function __construct(Settings $settings)
    {

        $this->settings = $settings;
    }

    function getAction(Tick $tick)
    {
        $directions = $this->getAvailableDirections($tick->hero);
        $estimators = [
            OutPossibilityEstimator::class,
            SuicidePossibilityEstimator::class,
            WayOutEstimator::class,
            TimeOutEstimator::class,
            GreedyWayEstimator::class,
            EnemyDangerEstimator::class,
        ];
        foreach ($directions as $direction => &$weight) {
            foreach ($estimators as $estimator) {
                if ($weight > 0) {
                    /** @var AbstractEstimator $esInstance */
                    $esInstance = new $estimator($this->settings, $tick);
                    $weight = $esInstance->estimate($direction, $weight);
                }
            }
        }
        BFSCached::clearCache();
        asort($directions);
        $keys = array_keys($directions);
        return array_pop($keys);
    }

    function getDebugMessage()
    {
        return 'debug';
    }

    protected function getAvailableDirections(Player $player)
    {
        $directions = AVAILABLE_DIRECTIONS[$player->direction];
        $result = [];
        foreach ($directions as $direction) {
            $result[$direction] = 1;
        }
        return $result;
    }

}
