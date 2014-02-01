<?php ?>
<div id="contentbox">
	<h2>Load an existing game</h2>
	<table>
		<tr>
			<th>Game Name</th>
			<th>&nbsp;</th>
		</tr>
		<?php
		if (count($games) == 0):
		?>
		<tr>
			<td colspan="2">No Games Found</td>
		</tr>
		<?php
		else:
		foreach($games as $game):
		?>
		<tr>
			<td>
				<?php
				echo $this->Html->link(
					$game['Game']['name'],
					array(
						'controller' => 'games',
						'action' => 'load',
						'gameid' => $game['Game']['id'],
					)
				);
				?>
			</td>
			<td>&nbsp;</td>
		</tr>
		<?php
		endforeach;
		endif;
		?>
	</table>
	<h2>Create a new game</h2>
	<?php
	echo $this->Html->link(
		'Create game',
		array(
			'controller' => 'games',
			'action' => 'create',
		)
	);
	?>
</div>
<!-- 
<pre>
<?php print_r($games); ?>
</pre>
-->
