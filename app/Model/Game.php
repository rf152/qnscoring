<?php

class Game extends AppModel {
	public $hasMany = array(
		'Game_Round' => array(
			'className' => 'Round',
			'order' => 'Game_Round.round_number ASC',
		),
		'Game_Team' => array(
			'className' => 'Team',
			'order' => 'Game_Team.total DESC',
		),
	);
}

?>
