<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container">
    <div class="row">
        <h4 class="col-lg-12 col-md-12 col-sm-12">Please fill the information below</h4>
    </div>
            <div class="selectionwraper city">
                <div class="input-group mb-3 selection" width=450px >
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="citylist">@City</label>
                    </div>
                    <select class="custom-select" id="citylist">
                        <option selected value = "default">Choose...</option>
                    </select>
                </div>
            </div>
            <div class="selectionwraper suburb">
                <div class="selection input-group mb-3" width=450px>
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="suburblist">@Suburb</label>
                    </div>
                    <select class="custom-select" id="suburblist" disabled>
                        <option selected value = "default">Choose...</option>
                    </select>
                </div>
            </div>
            <div class="selectionwraper type">
                    <div class="selection input-group mb-3" width=450px>
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="typeList">@Type</label>
                        </div>
                        <select class="custom-select" id="typeList" disabled>
                            <option selected value = "default">Choose...</option>
                            <option value = "word">word</option>
                            <option value = "sentence">sentence</option>
                            <option value = "word_list">word list</option>
                            <option value = "short_sentence">short sentence</option>
                            <option value = "unclassified">unclassified</option>
                        </select>
                    </div>
                </div>
            <textarea id="name" class="form-control" rows="5" name="name" placeholder="Enter the text that you want to record" value = ""></textarea>
    <div>

    </div>
</div>