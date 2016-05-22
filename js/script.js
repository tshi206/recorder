/**
 * ownCloud - recorder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Shawn <syu702@aucklanduni.ac.nz>
 * @copyright Shawn 2016
 */
/*
(function (document.getElementById, OC) {

	document.getElementById(document).ready(function () {
		document.getElementById('#hello').click(function () {
			alert('Hello from your script file');
		});

		document.getElementById('#echo').click(function () {
			var url = OC.generateUrl('/apps/recorder/echo');
			var data = {
				echo: document.getElementById('#echo-content').val()
			};

			document.getElementById.post(url, data).success(function (response) {
				document.getElementById('#echo-result').text(response.echo);
			});

		});
*/

document.addEventListener( 'DOMContentLoaded', function () {
    var ready = function ( fn ) {

        // Sanity check
        if ( typeof fn !== 'function' ) return;

        // If document is already loaded, run method
        if ( document.readyState === 'complete'  ) {
            return fn();
        }

        // Otherwise, wait until document is loaded
        // The document has finished loading and the document has been parsed but sub-resources such as images, stylesheets and frames are still loading. The state indicates that the DOMContentLoaded event has been fired.
        document.addEventListener( 'interactive', fn, false );

        // Alternative: The document and all sub-resources have finished loading. The state indicates that the load event has been fired.
        // document.addEventListener( 'complete', fn, false );

    };

}

// Example

ready(function() {
    // Do stuff...
            function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
                navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
            }

            var mediaConstraints = {
                audio: true
            };

        // alert("JS demo is applied!");
            document.getElementById('#start-recording').onclick = function () {
        // alert("Function start is called!");
                this.disabled = true;
                captureUserMedia(mediaConstraints, onMediaSuccess, onMediaError);
            };

            document.getElementById('#stop-recording').onclick = function() {
                this.disabled = true;
                mediaRecorder.stop();
                mediaRecorder.stream.stop();

                document.getElementById('#pause-recording').disabled = true;
                document.getElementById('#start-recording').disabled = false;
            };

            document.getElementById('#pause-recording').onclick = function() {
                this.disabled = true;
                mediaRecorder.pause();

                document.getElementById('#resume-recording').disabled = false;
            };

            document.getElementById('#resume-recording').onclick = function() {
                this.disabled = true;
                mediaRecorder.resume();

                document.getElementById('#pause-recording').disabled = false;
            };

            document.getElementById('#save-recording').onclick = function() {
                this.disabled = true;
                mediaRecorder.save();
            };

            var mediaRecorder;

            function onMediaSuccess(stream) {
                var audio = document.createElement('audio');

                audio = mergeProps(audio, {
                    controls: true,
                    muted: true,
                    src: URL.createObjectURL(stream)
                });
                audio.play();

                audiosContainer.appendChild(audio);
                audiosContainer.appendChild(document.createElement('hr'));

                mediaRecorder = new MediaStreamRecorder(stream);
                mediaRecorder.stream = stream;
                mediaRecorder.mimeType = document.getElementById('audio-mimeType').value;
                mediaRecorder.audioChannels = !!document.getElementById('left-channel').checked ? 1 : 2;
                mediaRecorder.ondataavailable = function(blob) {
                    var a = document.createElement('a');
                    a.target = '_blank';
                    a.innerHTML = 'Open Recorded Audio No. ' + (index++) + ' (Size: ' + bytesToSize(blob.size) + ') Time Length: ' + getTimeLength(timeInterval);

                    a.href = URL.createObjectURL(blob);

                    audiosContainer.appendChild(a);
                    audiosContainer.appendChild(document.createElement('hr'));
                };

                var timeInterval = document.getElementById('#time-interval').value;
                if (timeInterval) timeInterval = parseInt(timeInterval);
                else timeInterval = 5 * 1000;

                // get blob after specific time interval
                mediaRecorder.start(timeInterval);

                document.getElementById('#stop-recording').disabled = false;
                document.getElementById('#pause-recording').disabled = false;
                document.getElementById('#save-recording').disabled = false;
            }

            function onMediaError(e) {
                console.error('media error', e);
            }

            var audiosContainer = document.getElementById('audios-container');
            var index = 1;

            // below function via: http://goo.gl/B3ae8c
            function bytesToSize(bytes) {
                var k = 1000;
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                if (bytes === 0) return '0 Bytes';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(k)), 10);
                return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
            }

            // below function via: http://goo.gl/6QNDcI
            function getTimeLength(milliseconds) {
                var data = new Date(milliseconds);
                return data.getUTCHours() + " hours, " + data.getUTCMinutes() + " minutes and " + data.getUTCSeconds() + " second(s)";
            }

            window.onbeforeunload = function() {
                document.getElementById('#start-recording').disabled = false;
            };
});

/*	});

})(jQuery, OC);
*/