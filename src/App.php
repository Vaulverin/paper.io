<?php

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
        foreach ($directions as $direction => &$wight) {

        }
        asort($directions);
        $keys = array_keys($directions);
        return array_pop($keys);
    }

    function getDebugMessage()
    {
        return 'debug';
    }

    function getAvailableDirections(Player $player)
    {
        $directions = AVAILABLE_DIRECTIONS[$player->direction];
        $result = [];
        foreach ($directions as $direction) {
            $result[$direction] = 1;
        }
        return $result;
    }

}
