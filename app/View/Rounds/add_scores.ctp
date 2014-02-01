<?php echo $this->Form->create('Scores'); ?>

<?php
	echo $this->Form->input(
		'roundid',
		array(
			'default' => $roundid,
			'label' => false,
			'type' => 'hidden',
		)
	);
?>
<h3>Add scores for round <?php echo $roundid; ?></h3>

<div id="errors"></div>
<table class="insertscores" cellspacing="0">
	<tr>
		<td>Table #</td>
		<td>Score</td>
		<td>J</td>
		<td>C</td>
	</tr>
	<?php
	foreach ($teams as $id=>$name):
	?>
	<tr>
		<td><?php echo $name; ?></td>
		<td>
			<?php
			echo $this->Form->input(
				"team.$id.value",
				array(
					'label' => false,
				)
			);
			?>
		</td>
		<td>
			<?php
			echo $this->Form->input(
				"team.$id.joker",
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
				"team.$id.chicken",
				array(
					'type' => 'checkbox',
					'label' => false,
				)
			);
			?>
		</td>
	</tr>
	<?php
	endforeach;
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
		},
		target: errors,
		dataType: 'json'
	}
);


</script>
<!-- 
<?php print_r($teams); ?>
-->
