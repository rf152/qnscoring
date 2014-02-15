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
	
	public function afterSave() {
		$teamid = $this->data['Score']['team_id'];
		$this->Score_Team->recursive = -1;
		$team = $this->Score_Team->find(
			'first',
			array(
				'conditions' => array(
					'id' => $teamid,
				),
			)
		);
		$sum = $this->find(
			'first',
			array(
				'conditions' => array(
					'team_id' => $team['Score_Team']['id'],
				),
				'fields' => array(
					"SUM(value) AS total",
				),
			)
		);
		$total = $sum[0]['total'];
		$team['Score_Team']['total'] = $total;
		$this->Score_Team->save($team);
	}
}

?>
