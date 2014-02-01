<?php

class Team extends AppModel {
	public $belongsTo = array(
		'Team_Game' => array(
			'className' => 'Game',
			'foreignKey' => 'game_id',
		)
	);
	
	public $hasMany = array(
		'Team_Score' => array(
			'className' => 'Score',
		),
	);
}

?>
