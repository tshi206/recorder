<!-- 
<div id="controls">
    <img id="record" src="img/mic128.png" onclick="toggleRecording(this);">
    <a id="save" href="#"><img src="img/save.svg"></a>
  </div> -->
<button id = "record" onclick="toggleRecording(this);">Record</button>
<a id="save" href="#"><button>Save</button></a>
  <div id="viz">
    <canvas class="canvasClass" id="analyser" width="1024" height="500"></canvas>
    <canvas class="canvasClass" id="wavedisplay" width="1024" height="500"></canvas>
  </div>
  
        <!-- <section class="experiment"> -->
<!--             <label for="time-interval">Time Interval (milliseconds):</label>
            <input type="text" id="time-interval" value="5000">ms

 -->            
 <!-- <br> -->
<!--             <select id="audio-mimeType">
                <option>audio/webm</option>
                <option>audio/wav</option>
            </select>
 -->
      <!--       <button id="start-recording">Start</button>
            <button id="stop-recording" disabled>Stop</button>

            <button id="pause-recording" disabled>Pause</button>
            <button id="resume-recording" disabled>Resume</button>

            <button id="save-recording" disabled>Save</button>

            <br>
            <br>
 -->
<!--             <input id="left-channel" type="checkbox" checked>
            <label for="left-channel">Only Left Channel?</label>

 -->	 
 <!--    <button id="hello">Hello</button>
        </section>

        <section class="experiment">
            <div id="audios-container"></div>
        </section>
 -->

<!-- 
    <div class="container">
      <h1><a href="https://github.com/higuma/wav-audio-encoder-js">WavAudioEncoder.js</a> demo</h1>
      <p>Audio recording to Waveform Audio (.wav) test with Web Audio API</p>
      <hr>
      <div class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label">Audio input</label>
          <div class="col-sm-2">Test tone</div>
          <div class="col-sm-3">
            <input id="test-tone-level" type="range" min="0" max="100" value="0">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3"></div>
          <div class="col-sm-2">
            <input id="microphone" type="checkbox"> Microphone
          </div>
          <div class="col-sm-3">
            <input id="microphone-level" type="range" min="0" max="100" value="0" class="hidden">
          </div>
        </div><br>
        <div class="form-group">
          <label class="col-sm-3 control-label">Encoding process</label>
          <div class="col-sm-9">
            <input type="radio" name="encoding-process" mode="separate" checked> Encode with worker after recording (safer)
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <input type="radio" name="encoding-process" mode="background"> Encode with worker on recording background (intermediate)
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <input type="radio" name="encoding-process" mode="direct"> Encode on recoring directly without worker (risky)
          </div>
        </div><br>
        <div class="form-group">
          <label class="col-sm-3 control-label">Recording buffer size</label>
          <div class="col-sm-2">
            <input id="buffer-size" type="range" min="0" max="6">
          </div>
          <div id="buffer-size-text" class="col-sm-7"></div>
        </div>
        <div class="form-group">
          <div class="col-sm-3"></div>
          <div class="col-sm-9 text-warning"><strong>Warning: </strong><span>setting size below browser default may fail recording.</span></div>
        </div><br>
        <div class="form-group">
          <div class="col-sm-3 control-label"><span id="recording" class="text-danger hidden"><strong>RECORDING</strong></span>&nbsp; <span id="time-display">00:00</span></div>
          <div class="col-sm-3">
            <button id="record" class="btn btn-danger">RECORD</button>
            <button id="cancel" class="btn btn-default hidden">CANCEL</button>
          </div>
          <div class="col-sm-6"><span id="date-time" class="text-info"></span></div>
        </div>
      </div>
      <hr>
      <h3>Recordings</h3>
      <div id="recording-list"></div>
    </div>
 -->
