<?php

class TeamsController extends AppController {
	public function beforeFilter() {
		$this->layout = 'ajax';
	}
	public function edit() {
		$game = $this->getGame();
		if ($this->request->is('post')) {
			$this->Team->recursive = -1;
			$gameid = $game['Game']['id'];
			$teams = $this->data['Teams'];
			// Just check for empty ones
			for ($i=0;$i<count($teams);$i++) {
				$team = $teams[$i];
				if ($team['name'] == '') {
					$oldteam = $this->Team->find(
						'first',
						array(
							'conditions' => array(
								'id' => $team['id'],
							),
						)
					);
					$teams[$i]['name'] = $oldteam['Team']['name'];
				}
			}
			if ($this->Team->saveMany($teams)) {
				$content = array(
					'status' => 'success',
					'message' => 'Success',
				);
				$this->set('content', $content);
				$this->render('/Common/json', 'ajax');
			} else {
				$content = array(
					'status' => 'fail',
					'message' => 'An error occurred',
				);
				$this->set('content', $content);
				$this->render('/Common/json', 'ajax');
			}
		}
		$this->Team->recursive = -1;
		$teams = $this->Team->find(
			'all',
			array(
				'conditions' => array(
					'game_id' => $game['Game']['id'],
				),
			)
		);
		$this->set('teams', $teams);
		$this->set('game', $game);
	}
}
