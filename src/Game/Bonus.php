<?php


namespace Game;

const BONUS_TYPE_ACCELERATION = 'n';
const BONUS_TYPE_SLOWDOWN = 's';
const BONUS_TYPE_SAW = 'saw';

/**
 * @property array position [x,y]
 * @property string type
 * @property int ticks
 */
class Bonus
{
    function __construct($params)
    {
        $this->type = $params['type'];
        $this->position = [-1, -1];
        if (isset($params['position'])) {
            $this->position = $params['position'];
        }
        $this->ticks = -1;
        if (isset($params['ticks'])) {
            $this->ticks = $params['ticks'];
        }

    }

}
