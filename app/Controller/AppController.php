<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public function beforeFilter() {
		Controller::loadModel('Game');
		if (!(
			$this->request->params['controller'] == 'games' &&
			(
				$this->request->params['action'] == 'show' ||
				$this->request->params['action'] == 'load' ||
				$this->request->params['action'] == 'create'
			)
		)) {
			if ($this->Session->check('Game.id')) {
				$game = $this->Game->find(
					'first',
					array(
						'conditions' => array(
							'Game.id' => $this->Session->read('Game.id'),
						),
					)
				);
				if (!isset($game['Game'])) {
					$this->Session->delete('Game.id');
					throw new NotFoundException('Game not found');
				}
			} else {
				$this->redirect(
					array(
						'controller' => 'games',
						'action' => 'show',
					)
				);
			}
		}
	}
	
	protected function getGame() {
		$this->loadModel('Game');
		$game = $this->Game->find(
			'first',
			array(
				'conditions' => array(
					'Game.id' => $this->Session->read('Game.id'),
				),
			)
		);
		return $game;
	}
}
