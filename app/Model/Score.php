<?php

class Score extends AppModel {
	public $belongsTo = array(
		'Score_Round' => array(
			'className' => 'Round',
			'foreignKey' => 'round_id',
		),
		'Score_Team' => array(
			'className' => 'Team',
			'foreignKey' => 'team_id',
		),
	);
}

?>
