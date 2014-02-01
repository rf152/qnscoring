<?php

class Game extends AppModel {
	public $hasMany = array(
		'Game_Round' => array(
			'className' => 'Round',
		),
		'Game_Team' => array(
			'className' => 'Team',
			'order' => 'Game_Team.total DESC',
		),
	);
}

?>
