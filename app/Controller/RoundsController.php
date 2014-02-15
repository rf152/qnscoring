<?php

class RoundsController extends AppController {
	function index() {
		$rounds = $this->Round->find('all');
		$this->set('rounds', $rounds);
	}
	
	function addScores() {
		$this->loadModel('Team');
		if ($this->request->is('post')) {
			$rid = $this->data['Scores']['roundid'];
			
			//print_r($this->data);
			$this->loadModel('Score');
			$datasource = $this->Score->getdatasource();
			$datasource->begin();
			foreach($this->data['team'] as $team) {
				//echo "Team " .  $team['id'] . ": " . $team['value'];
				$score = $team['value'];
				$joker = 0;
				$chicken = 0; 
				$mod = substr($score, strlen($score) - 1, 1);
				if (!is_numeric($mod)) {
					$mod = strtolower($mod);
					$score = substr($score, 0, strlen($score) -1);
					if (!is_numeric($score)) {
						//this isn't a numeric score.
						$content = array(
							'status' => 'fail',
							'message' => 'Please ensure all scores are formatted correctly',
						);
						$datasource->rollback();
						$this->set('content', $content);
						$this->render('/Common/json', 'ajax');
						die("NONNUMERIC");
					}
					if ($mod <> "j" && $mod <> "c") {
						$content = array(
							'status' => 'fail',
							'message' => 'Please ensure all scores are formatted correctly',
						);
						$datasource->rollback();
						$this->set('content', $content);
						$this->render('/Common/json', 'ajax');
					}
					if ($mod == "c") {
						$score = 0;
						$chicken = 1;
					}
					if ($mod == "j") $joker = 1;
				}
				// Check if there is a previous score for this:
				$this->Score->recursive = -1;
				$s = $this->Score->find(
					'first',
					array(
						'conditions' => array(
							'Score.team_id' => $team['id'],
							'Score.round_id' => $rid,
						),
					)
				);
				if (isset($s['Score'])) {
					// There is!
					$data = $s;
				} else {
					$data = array(
						'Score' => array(
							'team_id' => $team['id'],
							'round_id' => $rid,
						),
					);
				}
				$data['Score']['joker'] = $joker;
				$data['Score']['chicken'] = $chicken;
				$data['Score']['value'] = $score;
				$this->Score->create();
				if (!$this->Score->save($data)) {
					$content = array(
						'status' => 'fail',
						'message' => 'An unknown error occurred',
					);
					$datasource->rollback();
					$this->set('content', $content);
					$this->render('/Common/json', 'ajax');
				}
			}
			$datasource->commit();
			$content = array(
				'status' => 'success',
				'message' => 'Success',
			);
			$this->set('content', $content);
			//$this->render('/Rounds/index', 'default');
			$this->render('/Common/json', 'ajax');
			//die("POSTING");
		}
		$game = $this->getGame();
		$teams = $this->Team->find(
			'all',
			array(
				'conditions' => array(
					'game_id' => $game['Game']['id'],
				),
			)
		);
		$rid = $this->passedArgs['roundid'];
		$this->loadModel('Round');
		$round = $this->Round->find(
			'first',
			array(
				'conditions' => array(
					'Round.id' => $rid,
				),
			)
		);
		$this->layout = 'ajax';
		
		$this->set('title_for_layout', 'Add Scores');
		$this->set('round', $round);
		$this->set('game', $game);
		$this->set('teams', $teams);
	}
}

?>
