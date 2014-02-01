<?php

class Round extends AppModel {
	public $belongsTo = array(
		'Round_Game' => array(
			'className' => 'Game',
			'foreignKey' => 'game_id',
		)
	);
	
	public $hasMany = array(
		'Round_Score' => array(
			'className' => 'Score',
		),
	);
}

?>
