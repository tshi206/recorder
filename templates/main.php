
<?php
script('recorder', 'script');
style('recorder', 'style');
script('recorder', 'MediaStreamRecorder');
// script('recorder', 'audiodisplay');
// script('recorder', 'main');
script('recorder', 'recorder');
style('recorder', 'recorder');
?>

<div id="app">
	<div id="app-navigation">
		<?php print_unescaped($this->inc('part.navigation')); ?>
		<?php print_unescaped($this->inc('part.settings')); ?>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('recorder')); ?>
		</div>
	</div>

</div>
