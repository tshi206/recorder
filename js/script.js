/**
 * ownCloud - recorder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Shawn <syu702@aucklanduni.ac.nz>
 * @copyright Shawn 2016
 */

(function ($, OC) {

    $(document).ready(function () {
        $('#hello').click(function () {
            alert('Hello from your script file');
        });

        $('#echo').click(function () {
            var url = OC.generateUrl('/apps/recorder/echo');
            var data = {
                echo: $('#echo-content').val()
            };

            $.post(url, data).success(function (response) {
                $('#echo-result').text(response.echo);
            });

        });

            function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
                navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
            }

            var mediaConstraints = {
                audio: true
            };

            // var pauseRecording = $('#pause-recording');
            $('#start-recording').prop('disabled',false);
            $('#start-recording').click(function() {
                this.disabled = true;
                // $('#pause-recording').prop('disabled', false);
                // $('#stop-recording').prop('disabled', false);

                captureUserMedia(mediaConstraints, onMediaSuccess, onMediaError);
            });

            $('#stop-recording').click(function() {
                this.disabled = true;
                mediaRecorder.stop();
                // mediaRecorder.stream.stop();

                $('#pause-recording').prop('disabled', true);
                $('#start-recording').prop('disabled', false);
            });

            $('#pause-recording').click(function() {
                this.disabled = true;
                mediaRecorder.pause();

                $('#resume-recording').prop('disabled', false);
            });

            $('#resume-recording').click(function() {
                this.disabled = true;
                mediaRecorder.resume();

                $('#pause-recording').prop('disabled', false);
            });

            $('#save-recording').click(function() {
                this.disabled = true;
                mediaRecorder.save();
            });

            var mediaRecorder;

            function onMediaSuccess(stream) {
                var audio = document.createElement('audio');

                audio = mergeProps(audio, {
                    controls: false,
                    muted: true,
                    src: URL.createObjectURL(stream)
                });
                audio.play();

                // audiosContainer.appendChild(audio);
                // audiosContainer.appendChild(document.createElement('hr'));

                mediaRecorder = new MediaStreamRecorder(stream);
                mediaRecorder.stream = stream;
                mediaRecorder.mimeType = 'audio/wav'; /*document.getElementById('audio-mimeType').value;*/
                mediaRecorder.audioChannels = 1; /*!!document.getElementById('left-channel').checked ? 1 : 2;*/
                // mediaRecorder.ondataavailable = function(blob) {
                //     var a = document.createElement('a');
                //     a.target = '_blank';
                //     a.innerHTML = 'Open Recorded Audio No. ' + (index++) + ' (Size: ' + bytesToSize(blob.size) + ') Time Length: ' + getTimeLength(timeInterval);

                //     a.href = URL.createObjectURL(blob);

                //     audiosContainer.appendChild(a);
                //     audiosContainer.appendChild(document.createElement('hr'));
                // };
                

                // mediaRecorder.onstop = function() {
                //     // recording has been stopped.
                // };

/*                var timeInterval = $('#time-interval').value;
                if (timeInterval) timeInterval = parseInt(timeInterval);
                else timeInterval = 5 * 1000;

*/ 
                var timeInterval = 1000;
               // get blob after specific time interval
                mediaRecorder.start(timeInterval);

                $('#stop-recording').prop('disabled', false);
                $('#pause-recording').prop('disabled', false);
                $('#save-recording').prop('disabled', false);
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

    });

})(jQuery, OC);
