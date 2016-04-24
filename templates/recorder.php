<?php
<script type="text/javascript" src="https://cdn.webrtc-experiment.com/MediaStreamRecorder.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/webrtc/adapter/master/adapter.js"></script>
script('recorder', 'audiodisplay');
script('recorder', 'main');
script('recorder', 'recorder');
style('recorder', 'recorder');
?>

<div>
    <button id="start-recording" onclick="toggleRecording(this);">Record</button>
    <button id="stop-recording" disabled>Stop Recording</button>
    <button id="save-recording" disabled>Save Recording</button>
    <br><br>
</div>
