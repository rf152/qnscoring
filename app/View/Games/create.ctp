<?php
echo $this->Form->create('Game');
?>
	<h3>Create new game</h3>
	<p class="hint">
		Enter the details below
	</p>
	<div id="errors"></div>
	<table class="ajaxtable">
		<tr>
			<td>
				<strong>Game Name</strong>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo $this->Form->input(
					'name',
					array(
						'label' => false,
					)
				);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Number of teams</strong>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo $this->Form->input(
					'teamcount',
					array(
						'label' => false,
						'type' => 'number',
					)
				);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Number of rounds</strong>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo $this->Form->input(
					'round_count',
					array(
						'label' => false,
						'type' => 'number',
					)
				);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Interval round</strong>
				<p class="hint">
					Enter zero for no interval round
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo $this->Form->input(
					'interval_round',
					array(
						'label' => false,
						'type' => 'number',
					)
				);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo $this->Form->submit('Create');
				?>
			</td>
		</tr>
	</table>
<script type="text/javascript">
$('#GameCreateForm').ajaxForm(
	{
		success: function (d) {
			if (d.status == 'fail') {
				$('#errors').html(d.message);
			}
			if (d.status == 'success') {
				location.href=('/games/load/gameid:' + d.gameid);
			}
		},
		target: errors,
		dataType: 'json'
	}
);/**/
</script>
