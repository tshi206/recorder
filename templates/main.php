
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

<!-- Modals: They must be put at the highest level of the DOM hierarchy -->
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
<!-- Popup1 -->
<div class="modal fade" id="popup1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">A friendly reminder:)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Please fill in the textarea before downloading it. Make sure your text inside the text area meets the requirements: (1) short sentence - at least 3 words. (2) sentence - at least 2 words. (3) word, list of words, and other - at least 1 word. Please ensure you separate each word by SINGLE SPACE.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>
<!-- Popup2 -->
<div class="modal fade" id="popup2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">A friendly reminder:)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Please download and listen to your recording before uploading it. In addition, please make sure your text inside the text area meets the requirements: (1) short sentence - at least 3 words. (2) sentence - at least 2 words. (3) word, list of words, and other - at least 1 word. Please ensure you separate each word by SINGLE SPACE.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>
<!-- Popup3 -->
<div class="modal fade" id="popup3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">A friendly reminder:)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Your input text area is empty. Please put some text in and make sure your text inside the text area meets the requirements: (1) short sentence - at least 3 words. (2) sentence - at least 2 words. (3) word, list of words, and other - at least 1 word. Please ensure you separate each word by SINGLE SPACE.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>