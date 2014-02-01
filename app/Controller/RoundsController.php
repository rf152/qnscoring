<?php

class RoundsController extends AppController {
	function index() {
		$rounds = $this->Round->find('all');
		$this->set('rounds', $rounds);
	}
	
	function addScores() {
		Controller::loadModel('Team');
		if ($this->request->is('post')) {
			$content = array(
				'status' => 'fail',
				'message' => 'not implemented',
			);
			$this->set('content', $content);
			$this->render('/Rounds/json', 'ajax');
		}
		$game = $this->getGame();
		$teams = $this->Team->find(
			'list',
			array(
				'conditions' => array(
					'game_id' => $game['Game']['id'],
				),
			)
		);
		$rid = $this->passedArgs['roundid'];
		$this->layout = 'ajax';
		
		$this->set('title_for_layout', 'Add Scores');
		$this->set('roundid', $rid);
		$this->set('game', $game);
		$this->set('teams', $teams);
	}
}

?>
