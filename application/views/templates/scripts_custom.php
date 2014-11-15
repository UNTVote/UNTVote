<?php
// check to see if cdnScripts array exists before loading any cdns
?>
<?php if(isset($cdnScripts)): ?>
	<!-- load the cdn scripts -->
	<?php foreach ($cdnScripts as $cdnScript) : ?>
		<script src="<?=$cdnScript?>"></script>
	<?php endforeach?>
<?php endif?>

<!-- load the custom javascript files -->
<?php if(isset($scripts)): ?>
	<!-- load the scripts -->
	<?php foreach ($scripts as $script) : ?>
		<?=js($script)?>
	<?php endforeach?>
<?php endif?>
