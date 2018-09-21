<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div id="recorder" class="container">
    <div id="main-area" style="text-align: center;">
        <div class="row">
            <h4 id="welcome" class="col-lg-12 col-md-12 col-sm-12">Please fill the information below before you start your recording</h4>
        </div>
        <div class="selectionwraper city">
            <div class="input-group mb-3 selection" width=450px >
                <div class="input-group-prepend">
                    <label class="input-group-text" for="citylist">Choose your city</label>
                </div>
                <select class="custom-select" id="city" name="type" title="city">
                </select>
            </div>
        </div>
        <div class="selectionwraper suburb">
            <div class="selection input-group mb-3" width=450px>
                <div class="input-group-prepend">
                    <label class="input-group-text" for="suburblist">Choose your suburb</label>
                </div>
                <select class="custom-select" id="suburb" name="type" title="suburb">
                </select>
            </div>
        </div>
        <div class="selectionwraper type">
            <div class="selection input-group mb-3" width=450px>
                <div class="input-group-prepend">
                    <label class="input-group-text" for="typeList">Type of recording</label>
                </div>
                <select class="custom-select" id="type" name="type" title="type">
                    <option value="word" <?php if (($_['type']) == 'word') echo ' selected="selected"'; ?>>word</option>
                    <option value="listword" <?php if (($_['type']) == 'listword') echo ' selected="selected"'; ?>>list of words (&lt;20 words)</option>
                    <option value="shortsentence" <?php if (($_['type']) == 'shortsentence') echo ' selected="selected"'; ?>>short sentence (&gt;3 words)</option>
                    <option value="sentence" <?php if (($_['type']) == 'sentence') echo ' selected="selected"'; ?>>sentence</option>
                    <option value="other" <?php if (($_['type']) == 'other') echo ' selected="selected"'; ?>>other</option>
                </select>
            </div>
        </div>
        <textarea id="name" name="name" class="form-control" rows="5" placeholder="Enter the text that you want to record. For example: Ko toku kupu i konei"></textarea>
        <div id="recording-btn-group" class="btn-group btn-group-lg" role="group" aria-label="Start stop">
            <button id="start-recording" type="button" class="btn btn-secondary"><i class="fa fa-microphone"></i><br>Start</button>
            <button id="stop-recording" type="button" class="btn btn-secondary" disabled ><i class="fa fa-microphone-slash"></i><br>Stop</button>
            <button id="listen-recording" disabled type="button" class="btn btn-secondary"><i class="fa fa-download"></i><br>Download</button>
            <button id="save-recording" disabled type="button" class="btn btn-secondary"><i class="fa fa-cloud-upload"></i><br>Upload</button>
        </div>
        <div class="timer-and-logs" >
            <span id="sw_m">00</span>:
            <span id="sw_s">00</span>
            <section class="logs">
                <div id="audios-container" style="display: inline-block; margin-right: 40px"></div>
                <label id ="edgeNotice" style="display: inline-block"></label>
                <label id ="edgeNotice2"></label>
            </section>
        </div>
        <div id="userID" class="hidden">
            <textarea id ="user" title="user"><?php p($_['user']); ?></textarea>
        </div>
    </div>
</div>