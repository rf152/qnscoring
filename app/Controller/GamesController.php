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
}
