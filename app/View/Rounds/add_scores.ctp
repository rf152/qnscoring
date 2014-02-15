<?php echo $this->Form->create('Scores'); ?>

<?php
	echo $this->Form->input(
		'roundid',
		array(
			'default' => $round['Round']['id'],
			'label' => false,
			'type' => 'hidden',
		)
	);
?>
<h3>Add scores for <?php echo $round['Round']['title']; ?></h3>
<p class="hint">
	Enter scores here. Suffix the score with a 'j' or 'c' if a Joker
	or Chicken were played.
</p>
<div id="errors"></div>
<table class="ajaxtable scorestable" cellspacing="0">
	<tr>
		<td>Table #</td>
		<td>Score</td>
		<!-- <td>J</td>
		<td>C</td> -->
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
				"team.$i.value",
				array(
					'label' => false,
				)
			);
			echo $this->Form->input(
				"team.$i.id",
				array(
					'type' => 'hidden',
					'default' => $team['Team']['id'],
				)
			);
			?>
		</td>
		<!-- <td>
			<?php
			echo $this->Form->input(
				"team.$i.joker",
				array(
					'type' => 'checkbox',
					'label' => false,
				)
			);
			?>
		</td>
		<td>
			<?php
			echo $this->Form->input(
				"team.$i.chicken",
				array(
					'type' => 'checkbox',
					'label' => false,
				)
			);
			?>
		</td> -->
	</tr>
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
$('#ScoresAddScoresForm').ajaxForm(
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
</script>
<!-- 
<?php print_r($teams); ?>
-->
