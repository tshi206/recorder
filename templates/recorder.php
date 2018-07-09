<section id="recorder" class="experiment">
        <br>

	<label>Choose the type of recording : </label>
		<select class="form-control" id="type" name="type">
		      <option value="word" <?php if (($_['type']) == 'word') echo ' selected="selected"'; ?>>word</option>
		      <option value="listword" <?php if (($_['type']) == 'listword') echo ' selected="selected"'; ?>>list of words (&lt;20 words)</option>
		      <option value="shortsentence" <?php if (($_['type']) == 'shortsentence') echo ' selected="selected"'; ?>> short sentence (&gt;3 words)</option>
		      <option value="sentence" <?php if (($_['type']) == 'sentence') echo ' selected="selected"'; ?>>sentence</option>
		      <option value="other" <?php if (($_['type']) == 'other') echo ' selected="selected"'; ?>>other</option>
		</select>
	<br>
	<br>

	<label>Enter the text that you want to record :</label>

	<br>
	<br>

	<textarea id="name" name="name" placeholder="ex: Ko toku kupu i konei" value = ""></textarea>

	<br>
	<br>

	<button id="start-recording">Start</button>
        <button id="stop-recording" disabled>Stop</button>

	<br>  <!--allow to align popup with their button -->
	<span id= "myPopup" class = "popuptext">Please fill the textarea before download it !</span>
        <button style="height:50px;width:150px" id="listen-recording" disabled>Download audio and Listen</button>	
	<button style="height:50px;width:150px" id="save-recording" disabled>Contribute to VoNZ project</button>
	<span id= "myPopup2" class = "popuptext">Please download the file on your computer first to put it on the server !</span>

        <br>
        <br>

 <!-- Allow to write the time during the recording -->
        <span id="sw_m">00</span>:
        <span id="sw_s">00</span>

</section>

<section class="experiment">
	<div id="audios-container"></div>
	<br>
	<label id ="edgeNotice" style ="color:green;"></label>
	<br>
	<label id ="edgeNotice2" style ="color:red;"></label>
</section> 

<div id="userID" class="hidden">
	<textarea id ="user" title="user"><?php p($_['user']); ?></textarea>
</div>

<div id="fenetre_alert">
	<label style ="color:black;">By clicking on the little "OK" button below, your recorded audio will be uploaded to the server.</label>
	<br>
	<label style ="color:red;">Your uploaded file will be saved as "#your-user-id#_#timestamp#_#some-generated-fileName#.wav". When the upload successfully completed, you will see a new window containing your files. DO NOT CLOSE THIS PAGE BEFORE THE UPLOADING COMPLETES.</label>
	<br>
	<button id="done">OK</button>
</div>
