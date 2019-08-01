<?php
use Game\Settings;
use Game\Tick;

require 'vendor/autoload.php';
require 'helpers.php';

function getServerMessage() {
    $line = trim(fgets(STDIN));
    return json_decode($line, true);
}
do {
    $settings = getServerMessage();
} while($settings['type'] !== 'start_game');
$gameSettings = new Settings($settings['params']);
$app = new App($gameSettings);

while (1) {
    $tick = getServerMessage();
    if ($tick['type'] === 'tick') {
        $gameTick = new Tick($tick['params']);
        $action = $app->getAction($gameTick);
        $debugMessage = $app->getDebugMessage();
        $command = array('command' => $action, 'debug' => $debugMessage);
        print json_encode($command)."\n";
    }
}
