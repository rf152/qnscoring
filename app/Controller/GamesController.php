<?php

class GamesController extends AppController {
	public function index() {
		$games = $this->Game->find('all');
		$this->set('games', $games);
	}
	
	public function scoresheet() {
		$this->Game->recursive = 2;
		$game = $this->getGame();
		
		// Loop through played rounds to organise scores
		$teamscores = array();
		
		foreach ($game['Game_Round'] as $round) {
			//ignore unscored rounds
			if (!isset($round['Round_Score'])) continue;
			foreach($round['Round_Score'] as $score) {
				$tid = $score['team_id'];
				$rid = $round['round_number'];
				$value = $score['value'];
				$chicken = $score['chicken'];
				$joker = $score['joker'];
				
				$teamscores[$tid][$rid] = array(
					'value' => $value,
					'chicken' => $chicken,
					'joker' => $joker,
				);
			}
		}
		
		$this->set('a', $this->Session->check('Game.admin'));
		$this->set('title_for_layout', 'Scoresheet');
		$this->set('game', $game);
		$this->set('teamscores', $teamscores);
	}
	
	public function show() {
		$games = $this->Game->find('all');
		$this->set('games', $games);
		$this->set('title_for_layout', 'Load Game');
	}
	
	public function load() {
		$gid = $this->passedArgs['gameid'];
		$this->Session->write('Game.id', $gid);
		$this->redirect(
			array(
				'controller' => 'games',
				'action' => 'scoresheet',
			)
		);
	}
	
	public function unload() {
		$this->Session->delete('Game.id');
		$this->redirect(
			array(
				'controller' => 'games',
				'action' => 'show',
			)
		);
	}
	
	public function takeAdmin() {
		$this->Session->write('Game.admin', 1);
		$this->redirect('/');
	}
	
	public function create() {
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$game = $this->data['Game'];
			$d = $this->data;
			unset($d['Game']['teamcount']);
			
			$datasource = $this->Game->getdatasource();
			$datasource->begin();
			if ($game['round_count'] < 1) {
				$this->datasource->rollback();
				$content = array(
					'status' => 'fail',
					'message' => 'I refuse to create a game with no rounds',
				);
				$this->set('content', $content);
				$this->render('/Common/json');
			}
			if (
				$game['interval_round'] > $game['round_count'] ||
				$game['interval_round'] < 0
			) {
				$this->datasource->rollback();
				$content = array(
					'status' => 'fail',
					'message' => 'Invalid interval round selection',
				);
				$this->set('content', $content);
				$this->render('/Common/json');
			}
			$this->Game->create();
			if (!$this->Game->save($d)) {
				$datasource->rollback();
				$content = array(
					'status' => 'fail',
					'message' => 'Unknown error',
				);
				$this->set('content', $content);
				$this->render('/Common/json');
			}
			$gid = $this->Game->id;
			$interval = $game['interval_round'] - 1;
			$j = 1;
			// Create the rounds
			for ($i=0;$i<$game['round_count'];$i++) {
				$round = array(
					'game_id' => $gid
				);
				$round['round_number'] = $i + 1;
				if ($i == $interval) {
					$shortname = 'i';
					$title = 'Interval Round';
				} else {
					$shortname = $j;
					$title = 'Round ' . $j;
					$j++;
				}
				$round['short_name'] = $shortname;
				$round['tite'] = $title;
				$rounds[] = $round;
			}
			// Save the rounds
			$this->loadModel('Round');
			if (!$this->Round->saveMany($rounds)) {
				$datasource->rollback();
				$content = array(
					'status' => 'fail',
					'message' => 'Unknown error',
				);
				$this->set('content', $content);
				$this->render('/Common/json');
			}
			
			// Create the teams
			for ($i=0;$i<$game['teamcount'];$i++) {
				$teams[] = array(
					'game_id' => $gid,
					'total' => 0,
					'table_number' => $i+1,
					'name' => 'Table ' . ($i+1),
				);
			}
			// Save the teams
			$this->loadModel('Team');
			if (!$this->Team->saveMany($teams)) {
				$datasource->rollback();
				$content = array(
					'status' => 'fail',
					'message' => 'Unknown error',
				);
				$this->set('content', $content);
				$this->render('/Common/json');
			}
			$datasource->commit();
			$content = array(
				'status' => 'success',
				'message' => 'Success',
				'gameid' => $gid,
			);
			$this->set('content', $content);
			$this->render('/Common/json');
		}
	}
}
