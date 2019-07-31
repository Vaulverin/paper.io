<?php
namespace Game;


/**
 * @property Player hero
 * @property int tickNum
 * @property Bonus[] bonuses
 * @property Player[] enemies
 */
class Tick
{
    function __construct(array $tick)
    {
        $this->tickNum = $tick['tick_num'];
        $this->bonuses = [];
        foreach ($tick['bonuses'] as $bonus) {
            $this->bonuses[] = new Bonus($bonus);
        }
        $this->enemies = [];
        foreach ($tick['players'] as $key => $player) {
            $gamePlayer = new Player($player);
            if ($key == 'i') {
                $this->hero = $gamePlayer;
            } else {
                $this->enemies[] = $gamePlayer;
            }
        }
    }
}
