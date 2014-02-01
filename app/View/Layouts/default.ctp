<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('tags');
		echo $this->Html->css('generic');
		echo $this->Html->css('overlay');
		
		echo $this->Html->script('jquery-1.11.0');
		echo $this->Html->script('jquery.form');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="overlay-bg">
	</div>
	<div id="overlay-content">
		This is an overlay ASDF
	</div>
	<div id="container">
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
