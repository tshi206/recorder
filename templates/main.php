
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
			<?php print_unescaped($this->inc('newLayout')); ?>
		</div>
	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="fenetre_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Thank you!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Thank you very much for contributing to Voices of New Zealand!
                Your uploaded file will be saved as "#your-user-id#_#timestamp#_#some-generated-fileName#.wav". When the upload successfully completes, you will see a new window containing your files. Please DO NOT close the recorder application (the web page) before your upload completes.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="done" type="button" class="btn btn-primary">Start uploading</button>
            </div>
        </div>
    </div>
</div>
