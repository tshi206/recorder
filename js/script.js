/**
 * ownCloud - recorder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Shawn <syu702@aucklanduni.ac.nz>, A.Daugieras <adau828@aucklanduni.ac.nz>, Mason <tshi206@aucklanduni.ac.nz>
 * @copyright Shawn,Daugieras,Mason 2018
 */

(function ($, OC) {

    $(document).ready(function () {

        // init global city and suburb state
        let cityName = "";
        let suburbName = "";

        // ADD LISTENER ON CITIES DROP-DOWN
        $('#city').on("change", () => {
            console.log("city selection event fired");
            let optionSelected = $("option:selected", this);
            let valueSelected = $('#city').find(":selected").text();
            cityName = valueSelected;
            console.log("selected value is : " + valueSelected);
            console.log("selected option is : " + optionSelected.text());
            $.ajax(OC.generateUrl("/apps/recorder/getsuburbs") + "/" + valueSelected, {
                method: 'GET',
                contentType: 'application/json'
            }).done(suburbs => {
                console.log("suburbs received");
                //console.log(suburbs);
                let suburbSelector = $('#suburb');
                // noinspection JSValidateTypes
                if (suburbSelector.children('option').toArray().length !== 0) {
                    suburbSelector.empty(); // remove all descendants, e.g., options
                }
                suburbs.forEach( suburb => {
                    let option = document.createElement("OPTION");
                    option.value = suburb;
                    option.text = suburb;
                    suburbSelector.append(option);
                    if (suburb === "Auckland Central" || suburb === suburbs[0]) {
                        option.selected = true;
                        suburbName = suburb;
                        suburbSelector.change();
                        console.log("suburb selected : " + suburb);
                    }
                });
            });
        });

        // ADD LISTENER ON SUBURBS DROP-DOWN
        $('#suburb').on("change", () => {
            let optionSelected = $("option:selected", this);
            let valueSelected = $('#suburb').find(":selected").text();
            suburbName = valueSelected;
            console.log("suburb value selected : " + valueSelected);
            console.log("suburb option selected : " + optionSelected.text());
        });

        // SEND REQUEST TO LOAD UP CITIES DROP-DOWN
        $.get(OC.generateUrl("/apps/recorder/getcities"), (cities) => {
            //console.log(cities);
            let citySelector = $('#city');
            cities.forEach( city => {
                let option = document.createElement("OPTION");
                option.value = city;
                option.text = city;
                citySelector.append(option);
                if (city === "Auckland") {
                    option.selected = true;
                    cityName = city;
                    citySelector.change();
                    console.log("city selected : " + city);
                }
            });
        });

        let mediaConstraints = {
            audio: true
        };
        let mediaRecorder;
        let timeInterval = 10000; //timeInterval by default, type = word
        let audiosContainer = document.getElementById('audios-container');
        let index = 1;
        // let i = 0;
        // let chunks = [];
        let currentBlob;
        let type = "word";
        // when deploying remember to replace local domain/ip with 'https://cervnzprd01.its.auckland.ac.nz'
        let initialURL = 'https://cervnzprd01.its.auckland.ac.nz/p4/owncloud/index.php/apps/files/?dir=/DataBase%20VoNZ%20word&fileid=56'; //by default, type = word
        let path = '/DataBase VoNZ word/newfile.txt'; //by default, type = word
        let fileName = "";
        let tokens = [];
        let secondStamp = 0;

        let Clock = {
            totalSeconds: 0,
            start: function () {
                let self = this;
                self.totalSeconds = 0;

                function pad(val) {
                    return val > 9 ? val : "0" + val;
                }

                this.interval = setInterval(function () {
                    self.totalSeconds += 1;
                    $("#sw_m").text(pad(Math.floor(self.totalSeconds / 60 % 60)));
                    $("#sw_s").text(pad(parseInt((self.totalSeconds % 60) + "")));
                }, 1000);
            },
            stop: function () {
                clearInterval(this.interval);
                delete this.interval;
            }
        };

        $('#start-recording').on('click', function() {
            this.disabled = true;
            $('#stop-recording').prop('disabled', false);
            $('#save-recording').prop('disabled',true);
            $('#listen-recording').prop('disabled',true);

            // noinspection JSUnresolvedVariable
            edgeNotice.innerHTML = "";
            // noinspection JSUnresolvedVariable
            edgeNotice2.innerHTML = "";
            currentBlob = null;

            typeChoice(document.getElementById('type').options.selectedIndex); //to define the timeInterval
            Clock.start();
            console.log("start recording");
            captureUserMedia(mediaConstraints, onMediaSuccess, onMediaError);
        });

        $('#stop-recording').on('click', function() {
            this.disabled = true;
            $('#start-recording').prop('disabled', false);
            $('#save-recording').prop('disabled',false);
            $('#listen-recording').prop('disabled',false);

            Clock.stop();
            mediaRecorder.stop();
            if (!IsChrome) {
                mediaRecorder.stream.stop();
            }
        });

        //Always save before recording to align Chrome on Mozilla behaviors
        $('#listen-recording').on('click', function() {

            if(document.getElementById("name").value + "" !== ""){
                this.disabled = true;

                tokens = document.getElementById("name").value.split(" ");
                typeChoice(document.getElementById('type').options.selectedIndex); //to define fileName

                let timeStamp = new Date();
                secondStamp = timeStamp.getDate() + "-"
                    + (timeStamp.getMonth() + 1) + "-"
                    + timeStamp.getFullYear() + "_"
                    + timeStamp.getHours() + "-"
                    + timeStamp.getMinutes() + "-"
                    + timeStamp.getSeconds();

                //download audio
                mediaRecorder.save(document.getElementById("user").value + '_' + secondStamp +'_'+ checkStringLength(fileName));
            }
            else{
                $('#popup1').modal();
            }
        });

        $('#save-recording').on('click', function() {

            if(document.getElementById("listen-recording").disabled === true){
                $('#fenetre_alert').modal('show');
            }
            else{
                $('#popup2').modal();
            }
        });


        $('#done').on('click', function() {

            // hidewindows('fenetre_alert');
            $('#fenetre_alert').modal('hide');
            typeChoice(document.getElementById('type').options.selectedIndex); //to define initialURL

            const reader = new FileReader();
            const reader2 = new FileReader();

            console.log(currentBlob.valueOf());
            console.log(currentBlob.toString());

            // Start reading the blob as base64 string.
            reader.readAsDataURL(currentBlob);

            // Start reading the blob as text.
            reader2.readAsText(currentBlob);

            // This fires after the blob has been read/loaded.
            reader.onloadend = function() {

                // get the remote ip address of the client
                $.get("https://api.ipify.org?format=json", (ipData) => {

                    console.log("Remote IP of this machine is : " + ipData.ip);

                    $.get("https://geoip.nekudo.com/api/" + ipData.ip, (geoInfoData) => {

                        console.log("Geo Info : " + geoInfoData);

                        let base64data = reader.result;
                        console.log(base64data);

                        //upload the base64 string and create  the text file with data of the recording
                        let url = OC.generateUrl('/apps/recorder/create');
                        let data = {
                            path: path,
                            content: document.getElementById('name').value,
                            blob: base64data,
                            geoInfo: geoInfoData,
                            type: type,
                            // GET SELECTED CITY NAME
                            city: cityName,
                            // GET SELECTED SUBURB NAME
                            suburb: suburbName
                        };
                        $.post(url, data).done(() => {
                            alert("File uploaded. If you do not see a new window opened, you can go to 'Files' at the top left corner");
                            window.open(initialURL);
                        }).fail((xhr, status, error) => {
                            alert(error);
                        });

                    });

                });

            };

            // This fires after the blob has been read/loaded.
            reader2.onloadend = () => {
                // noinspection JSUnresolvedVariable
                const text = reader2.result;
                // This is just for debug purposes
                console.log(text);
            };

        });

        function checkStringLength(str) {
            if (str.length >= 100) {
                return str.substr(0, 100);
            }
            return str;
        }

        //Assign different values in function of recording type
        function typeChoice(option){
            switch(option) {
                // when deploying remember to replace local domain/ip with 'https://cervnzprd01.its.auckland.ac.nz'
                case 0:
                    timeInterval = 10000; //for word
                    initialURL = 'https://cervnzprd01.its.auckland.ac.nz/p4/owncloud/index.php/apps/files/?dir=/DataBase%20VoNZ%20word&fileid=56';
                    fileName = tokens[0];
                    fileName = checkStringLength(fileName);
                    path ='/DataBase VoNZ word/'+document.getElementById("user").value + '_' + secondStamp +'_'+ fileName+'.txt';
                    type = "word";
                    break;
                case 1:
                    timeInterval = 30000; //for list of word
                    initialURL = 'https://cervnzprd01.its.auckland.ac.nz/p4/owncloud/index.php/apps/files/?dir=/DataBase%20VoNZ%20list_word&fileid=82';
                    fileName = tokens[0];
                    fileName = checkStringLength(fileName);
                    path ='/DataBase VoNZ list_word/'+document.getElementById("user").value + '_' + secondStamp +'_'+ fileName+'.txt';
                    type = "word list";
                    break;
                case 2:
                    timeInterval = 30000; //for short phrases
                    initialURL = 'https://cervnzprd01.its.auckland.ac.nz/p4/owncloud/index.php/apps/files/?dir=/DataBase%20VoNZ%20short_sentence&fileid=560';
                    fileName = tokens[2];
                    fileName = checkStringLength(fileName);
                    path ='/DataBase VoNZ short_sentence/'+document.getElementById("user").value + '_' + secondStamp +'_'+ fileName+'.txt';
                    type = "short sentence";
                    break;
                case 3:
                    timeInterval = 60000; //for sentences
                    initialURL = 'https://cervnzprd01.its.auckland.ac.nz/p4/owncloud/index.php/apps/files/?dir=/DataBase%20VoNZ%20sentence&fileid=83';
                    fileName = tokens[1];
                    fileName = checkStringLength(fileName);
                    path ='/DataBase VoNZ sentence/'+document.getElementById("user").value + '_' + secondStamp +'_'+ fileName+'.txt';
                    type = "sentence";
                    break;
                case 4:
                    timeInterval = 60000; //for other
                    initialURL = 'https://cervnzprd01.its.auckland.ac.nz/p4/owncloud/index.php/apps/files/?dir=/Unclassified%20Data%20VONZ&fileid=84';
                    fileName = tokens[0];
                    fileName = checkStringLength(fileName);
                    path ='/Unclassified Data VONZ/'+document.getElementById("user").value + '_' + secondStamp +'_'+ fileName+'.txt';
                    type = "unclassified";
                    break;
            }
        }

        function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
            navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
        }

        function onMediaSuccess(stream) {

            mediaRecorder = new MediaStreamRecorder(stream);
            mediaRecorder.stream = stream;
            mediaRecorder.mimeType = 'audio/wav';
            mediaRecorder.audioChannels = 1;
            mediaRecorder.ondataavailable = function(blob) {

                //Stop the recording if the time interval was exceed and the stop button was not press
                mediaRecorder.stop();
                if (!IsChrome) {
                    mediaRecorder.stream.stop();
                }

                if (Clock.totalSeconds*1000 === timeInterval  || Clock.totalSeconds*1000 >= timeInterval){
                    $('#start-recording').prop('disabled', false);
                    $('#stop-recording').prop('disabled',true);

                    Clock.stop();
                    // noinspection JSUnresolvedVariable
                    edgeNotice2.innerHTML = "Unsuccessfully recorded!";
                    alert("Your recording is too long, modify the type of recording or try again !");
                }
                else {

                    let blobURL = URL.createObjectURL(blob);
                    currentBlob = blob;

                    // noinspection JSUnresolvedVariable
                    edgeNotice.innerHTML = "Successfully recorded!";

                    let a = document.createElement('a');
                    a.target = '_blank';
                    a.color = 'aliceblue';
                    a.innerHTML = 'Audio Recorded ' + (index++) + '| Size: ' + bytesToSize(blob.size) + '| Time Length: ' + getTimeLength(Clock.totalSeconds*1000);

                    a.href = blobURL;

                    audiosContainer.appendChild(document.createElement('hr'));
                    audiosContainer.appendChild(a);
                    audiosContainer.appendChild(document.createElement('hr'));
                }

            };

            // get blob after specific time interval
            mediaRecorder.start(timeInterval);

            $('#stop-recording').prop('disabled', false);
            $('#save-recording').prop('disabled', true);
            $('#listen-recording').prop('disabled',true);
        }

        function onMediaError(e) {
            console.error('media error', e);
        }

        // below function via: http://goo.gl/B3ae8c
        function bytesToSize(bytes) {
            let k = 1000;
            let sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes === 0) return '0 Bytes';
            let i = parseInt(Math.floor(Math.log(bytes) / Math.log(k)) + "", 10);
            return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
        }

        // below function via: http://goo.gl/6QNDcI
        function getTimeLength(milliseconds) {
            let data = new Date(milliseconds);
            return data.getUTCHours() + " hours, " + data.getUTCMinutes() + " minutes and " + data.getUTCSeconds() + " second(s)";
        }
        /******** Stop Watch *******/

        //below function from steamproc
        // function xhr(url, data,initialURL, callback) {
        //     let request = new XMLHttpRequest();
        //     request.onreadystatechange = function () {
        //         if (request.readyState === 4 && request.status === 200) {
        //             callback(initialURL);
        //         }
        //     };
        //     request.open('POST', url);
        //     request.send(data);
        // }

    });

})(jQuery, OC);
