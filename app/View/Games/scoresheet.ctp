<?php
$this->Html->css('scoresheet', null, array('inline' => false));
$this->Html->script('clock', array('inline' => false));

if ($game['Game_Team'][0]['total'] == $game['Game_Team'][1]['total']) {
	//this is a draw!
	$leader = "Draw";
	$topscore = $game['Game_Team'][0]['total'];
} else {
	$leader = $game['Game_Team'][0]['name'];
	$topscore = $game['Game_Team'][0]['total'];
}
?>
<div id="header">
	<h1><?php echo $game['Game']['name']; ?></h1>
	<div id="gamestate">
		Current Leader:
		<span class="emphasis">
			<?php echo $leader; ?>
		</span>
		with
		<span class="emphasis">
			<?php echo $topscore; ?>
		</span>
		points.
	</div>
	<div id="clock"><?php echo date('H:i'); ?></div>
	<div class="clearthis">&nbsp;</div>
</div>

<table id="scoresheet" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th>
				Team Name
				<?php
				if ($a) {
					echo $this->Html->link(
						$this->Html->image(
							'edit_16.png'
						),
						array(
							'controller' => 'teams',
							'action' => 'edit',
						),
						array(
							'escape' => false,
							'class' => 'ajax',
						)
					);
				}
				?>
			</th>
			<?php
			foreach ($game['Game_Round'] as $round):
			?>
			<th class="roundname">
				<?php echo $round['short_name']; ?>
				<?php
				if ($a) {
					echo $this->Html->link(
						$this->Html->image(
							'add_16.png'
						),
						array(
							'controller' => 'rounds',
							'action' => 'addScores',
							'roundid' => $round['id'],
						),
						array(
							'escape' => false,
							'class' => 'ajax',
						)
					);
				}
				?>
			</th>
			<?php endforeach; ?>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($game['Game_Team'] as $team): ?>
		<tr>
			<td><?php echo $team['name']; ?></td>
			<?php
			for ($i = 1; $i <= $game['Game']['round_count']; $i++):
			
			// Check this round has been scored
			if (isset($teamscores[$team['id']][$i])):
			
			$thisround = $teamscores[$team['id']][$i];
			
			$class = $thisround['chicken'] ? ' class="chicken"' : '';
			$class = $thisround['joker'] ? ' class="joker"' : '';
			?>
			<td<?php echo $class; ?>><?php echo $thisround['value']; ?></td>
			<?php
			else:
			?>
			<td>-</td>
			<?php 
			endif; //Round has been scored
			endfor; // Looping through rounds
			?>
			<td><?php echo $team['total']; ?></td>
		</tr>
			
		<?php endforeach; ?>
	</tbody>
</table>

<div id="legend">
	Colour Scheme: <strong>Normal</strong> | <span class="joker">Joker</span> | <span class="chicken">Chicken</span>
</div>
<!--
<?php print_r($game); ?>
-->
