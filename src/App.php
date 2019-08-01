<?php

use Estimators\AbstractEstimator;
use Estimators\Edge;
use Estimators\Suicide;
use Game\Player;
use Game\Settings;
use Game\Tick;
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
            Edge::class,
            Suicide::class,
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
