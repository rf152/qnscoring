<?php echo $this->Form->create('Teams'); ?>
<h3>Change team names for <?php echo $game['Game']['name']; ?></h3>
<p class="hint">
	Enter the team names below. The current team names are auto-filled.
	If left blank, the team name will not be changed
</p>


<div id="errors"></div>
<table class="ajaxtable" cellspacing="0">
	<tr>
		<td>Table #</td>
		<td>Team Name</td>
	</tr>
	<?php
	for ($i=0;$i<count($teams);$i++):
	$team = $teams[$i];
	?>
	<tr>
		<td><?php echo $team['Team']['name']; ?></td>
		<td>
			<?php
			echo $this->Form->input(
				"Teams.$i.name",
				array(
					'label' => false,
					'default' => $team['Team']['name'],
					'class' => 'autoclear',
				)
			);
			?>
		</td>
	</tr>
	<?php
	echo $this->Form->input(
		"Teams.$i.id",
		array(
			'label' => false,
			'default' => $team['Team']['id'],
			'type' => 'hidden',
		)
	);
	?>
	<?php
	endfor;
	?>
	<tr>
		<td colspan="4">
			<center>
				<?php echo $this->Form->submit(); ?>
			</center>
		</td>
	</tr>
</table>


<script type="text/javascript">
$('#TeamsEditForm').ajaxForm(
	{
		success: function (d) {
			if (d.status == 'fail') {
				$('#errors').html(d.message);
			}
			if (d.status == 'success') {
				hideOverlay(true);
			}
		},
		target: errors,
		dataType: 'json'
	}
);/**/

$('.autoclear').focus(
	function () {
		$(this).val('');
	}
);

</script>
