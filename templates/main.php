
<?php

style('recorder', 'style');
style('recorder', 'recorder');

script('recorder', 'gumadapter');
script('recorder', 'MediaStreamRecorderupdate');
script('recorder', 'script');

?>

<div id="app">
	
	<div id="app-content">
		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('recorder')); ?>
		</div>
	</div>

</div>
