            function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
                navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
            }

            var mediaConstraints = {
                audio: true
            };

		alert("JS demo is applied!");
            $('#start-recording').click(function () {
		alert("Function start is called!");
                this.disabled = true;
                captureUserMedia(mediaConstraints, onMediaSuccess, onMediaError);
            });

            $('#stop-recording').click(function() {
                this.disabled = true;
                mediaRecorder.stop();
                mediaRecorder.stream.stop();

                $('#pause-recording').disabled = true;
                $('#start-recording').disabled = false;
            });

            $('#pause-recording').click(function() {
                this.disabled = true;
                mediaRecorder.pause();

                $('#resume-recording').disabled = false;
            });

            $('#resume-recording').click(function() {
                this.disabled = true;
                mediaRecorder.resume();

                $('#pause-recording').disabled = false;
            });

            $('#save-recording').click(function() {
                this.disabled = true;
                mediaRecorder.save();
            });

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

                var timeInterval = $('#time-interval').value;
                if (timeInterval) timeInterval = parseInt(timeInterval);
                else timeInterval = 5 * 1000;

                // get blob after specific time interval
                mediaRecorder.start(timeInterval);

                $('#stop-recording').disabled = false;
                $('#pause-recording').disabled = false;
                $('#save-recording').disabled = false;
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
                $('#start-recording').disabled = false;
            };
